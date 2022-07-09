<?php

namespace FluentForm\App\Modules\Form\Settings;

class FormCssJs
{

    public function addCssJs($form)
    {
        $metas = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $form->id)
            ->whereIn('meta_key', [
                '_custom_form_css',
                '_custom_form_js'
            ])
            ->limit(2)
            ->get();

        if(!$metas) {
            return;
        }

        foreach ($metas as $meta)
        {
            if($meta->meta_key == '_custom_form_css' && $meta->value) {
                $this->addCss($form, $meta->value);
            } else if($meta->meta_key == '_custom_form_js' && $meta->value) {
                $this->addJs($form, $meta->value);
            }
        }

    }

    public function addCss($form, $css)
    {
        if($css) {
            $css = str_replace('{form_id}', $form->id, $css);
            $css = str_replace('FF_ID', $form->id, $css);
            ?>
            <style type="text/css">
                <?php echo $css; ?>
            </style>
            <?php
        }
    }

    public function addJs($form, $customJS)
    {
        if(trim($customJS)) {
            add_action('wp_footer', function () use ($form, $customJS) {
                ?>
                <script type="text/javascript">
                    jQuery(document.body).on('fluentform_init_<?php echo $form->id; ?>', function (event, data) {
                        var $form = jQuery(data[0]);
                        var formId = "<?php echo $form->id; ?>";
                        var $ = jQuery;
                        try {
                            <?php echo $customJS; ?>
                        } catch (e) {
                            console.warn('Error in custom JS of Fluentform ID: '+$form.data('form_id'));
                            console.error(e);
                        }
                    });
                </script>
                <?php
            }, 100);
        }
    }

    /**
     * Get settings for a particular form by id
     * @return void
     */
    public function getSettingsAjax()
    {
        $formId = absint($_REQUEST['form_id']);
        wp_send_json_success(array(
            'custom_css' => $this->getData($formId, '_custom_form_css'),
            'custom_js'  => $this->getData($formId, '_custom_form_js'),
        ), 200);
    }

    /**
     * Save settings for a particular form by id
     * @return void
     */
    public function saveSettingsAjax()
    {
        $formId = absint($_REQUEST['form_id']);
        
        $css = $_REQUEST['custom_css'];
        $js = $_REQUEST['custom_js'];
        $css = wp_strip_all_tags(wp_unslash($css));
        $js = wp_unslash($js);

        $this->store($formId, '_custom_form_css', $css);
        $this->store($formId, '_custom_form_js', $js);

        wp_send_json_success([
            'message' => __('Custom CSS and JS successfully updated', 'fluentform')
        ], 200);
    }


    protected function getData($formId, $metaKey)
    {
        $row = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('meta_key', $metaKey)
            ->first();
        if ($row) {
            return $row->value;
        }
        return '';
    }


    protected function store($formId, $metaKey, $metaValue)
    {
        $row = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('meta_key', $metaKey)
            ->first();

        if (!$row) {
            return wpFluent()->table('fluentform_form_meta')
                ->insert([
                    'form_id' => $formId,
                    'meta_key' => $metaKey,
                    'value' => $metaValue
                ]);
        }

        return wpFluent()->table('fluentform_form_meta')
            ->where('id', $row->id)
            ->update([
                'value' => $metaValue
            ]);
    }
}