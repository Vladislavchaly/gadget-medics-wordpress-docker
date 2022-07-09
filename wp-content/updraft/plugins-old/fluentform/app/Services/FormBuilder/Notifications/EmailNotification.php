<?php

namespace FluentForm\App\Services\FormBuilder\Notifications;

use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Services\Emogrifier\Emogrifier;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentForm\View;

class EmailNotification
{
    /**
     * FluentForm\Framework\Foundation\Application
     * @var $app
     */
    protected $app = null;

    /**
     * Biuld the instance of this class
     * @param  FluentForm\Framework\Foundation\Application $app
     * @return $this
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Send the email notification
     * @param  array $notification [Notification settings from form meta]
     * @param  array $submittedData [User submitted form data]
     * @param  StdClass $form [The form object from database]
     * @return bool
     */
    public function notify($notification, $submittedData, $form, $entryId = false)
    {
        $headers = [
            'Content-Type: text/html; charset=UTF-8'
        ];

        if ($notification['fromName'] && $notification['fromEmail']) {
            $headers[] = "From: {$notification['fromName']} <{$notification['fromEmail']}>";
        } elseif ($notification['fromEmail']) {
            $headers[] = "From: <{$notification['fromEmail']}>";
        } elseif ($notification['fromName']) {
            $headers[] = "From: {$notification['fromName']}";
        }

        if (!empty($notification['bcc'])) {
            $bccEmail = $notification['bcc'];
            $headers[] = 'Bcc: ' . $bccEmail;
        }

        if (!empty($notification['cc'])) {
            $ccEmail = $notification['cc'];
            $headers[] = 'Cc: ' . $ccEmail;
        }

        if ($notification['replyTo']) {
            $headers[] = "Reply-To: <{$notification['replyTo']}>";
        }

        $headers = $this->app->applyFilters(
            'fluenttform_email_header', $headers, $notification
        );

        $attachments = $this->app->applyFilters(
            'fluentform_filter_email_notification',
            isset($notification['attachments']) ? $notification['attachments'] : [],
            $notification,
            $form,
            $submittedData
        );
        $emailBody = $notification['message'];

        if (!apply_filters('fluenform_send_plain_html_email', false, $form, $notification)) {
            $emailBody = $this->getEmailWithTemplate($emailBody, $form, $notification);
        }

        if( ArrayHelper::get($notification, 'sendTo.type') == 'field' && !empty($notification['sendTo']['field']) ) {
            $notification['sendTo']['email'] = ArrayHelper::get($submittedData, $notification['sendTo']['field']);
        }

        if ( !$notification['sendTo']['email'] || !$notification['subject'] ) {
            
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type' => 'submission_item',
                'source_id' => $entryId,
                'component' => 'EmailNotification',
                'status' => 'error',
                'title' => 'Email sending skipped',
                'description' => "Email skipped to send because email may not valid.<br />Subject: {$notification['subject']}. <br/>Email: " . $notification['sendTo']['email'],
            ]);
            return false;
        }

        if ($entryId) {
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type' => 'submission_item',
                'source_id' => $entryId,
                'component' => 'EmailNotification',
                'status' => 'info',
                'title' => 'Email sending initiated',
                'description' => "Email Notification broadcasted to " . $notification['sendTo']['email'] . ".<br />Subject: {$notification['subject']}",
            ]);

            /*
            * Inline email logger. It will work fine hopefully
            */
            add_action('wp_mail_failed', function ($error) use ($notification, $form, $entryId) {
                $failedMailSubject = ArrayHelper::get($error->error_data, 'wp_mail_failed.subject');
                if ($failedMailSubject == $notification['subject']) {
                    $reason = $error->get_error_message();
                    do_action('ff_log_data', [
                        'parent_source_id' => $form->id,
                        'source_type' => 'submission_item',
                        'source_id' => $entryId,
                        'component' => 'EmailNotification',
                        'status' => 'failed',
                        'title' => 'Email sending failed',
                        'description' => "Email Notification failed to sent.<br />Subject: {$notification['subject']}. <br/>Reason: " . $reason,
                    ]);
                }
            }, 10, 1);
        }

        $isMailSentSuccessfully = wp_mail(
            $notification['sendTo']['email'],
            $notification['subject'],
            $emailBody,
            $headers,
            $attachments
        );

        $this->emptyTmp($attachments);


        return $isMailSentSuccessfully;
    }

    /**
     * Delete attached files from tmp directory
     * @param  array $attachments
     * @return void
     */
    protected function emptyTmp($attachments)
    {
        if ($attachments) {
            foreach ($attachments as $path) unlink($path);
        }
    }

    /**
     * @param $formId
     * @todo: Implement Caching mechanism so we don't have to parse these things for every request
     * @return array
     */
    private function getFormInputsAndLabels($form)
    {
        $formInputs = FormFieldsParser::getInputs($form);

        $inputLabels = FormFieldsParser::getAdminLabels($form, $formInputs);

        return [
            'inputs' => $formInputs,
            'labels' => $inputLabels
        ];
    }

    public function getEmailWithTemplate($emailBody, $form, $notification)
    {
        $emailHeader = apply_filters('fluentform_email_header', '', $form, $notification);
        $emailFooter = apply_filters('fluentform_email_footer', '', $form, $notification);

        if (empty($emailHeader)) {
            $emailHeader = View::make('email.template.header', array(
                'form'         => $form,
                'notification' => $notification
            ));
        }

        if (empty($emailFooter)) {
            $emailFooter = View::make('email.template.footer', array(
                'form'         => $form,
                'notification' => $notification,
                'footerText' => $this->getFooterText($form, $notification)
            ));
        }

        $css = View::make('email.template.styles');
        $css = apply_filters('fluentform_email_styles', $css, $form, $notification);
        $emailBody = $emailHeader . $emailBody . $emailFooter;

        try {
            // apply CSS styles inline for picky email clients
            $emogrifier = new Emogrifier($emailBody, $css);
            $emailBody = $emogrifier->emogrify();

        } catch (Exception $e) {

        }
        return $emailBody;
    }


    private function getFooterText($form, $notification)
    {
        $option = get_option('_fluentform_global_form_settings');

        if($option && !empty($option['misc']['email_footer_text'])) {
            $footerText = $option['misc']['email_footer_text'];
        } else {
            $footerText = '&copy; ' . get_bloginfo( 'name', 'display' ).'.';
        }

        return apply_filters('fluentform_email_template_footer_text',$footerText, $form, $notification);;
    }

}
