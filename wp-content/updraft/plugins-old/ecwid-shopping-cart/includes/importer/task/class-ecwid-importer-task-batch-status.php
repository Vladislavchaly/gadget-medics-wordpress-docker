<?php

class Ecwid_Importer_Task_Batch_Status extends Ecwid_Importer_Task_Product_Base
{
	public static $type = 'batch_status';

	const STATUS_QUEUED = 'QUEUED';
	const STATUS_IN_PROGRESS = 'IN_PROGRESS';
	const STATUS_COMPLETED = 'COMPLETED';
	const STATUS_FAILED = 'FAILED';

	public function execute( Ecwid_Importer $exporter, array $task_data ) {

		$ticket = $task_data['ticket'];

		$api = new Ecwid_Api_V3();

		$result = $api->get_batch_status( $ticket );

		$batch = json_decode( $result['data'] );

		if ( $batch->status != self::STATUS_COMPLETED ) {
			$exporter->append_task(
				$this->build(
					array(
						'ticket' => $ticket,
						'timeout' => '1'
					)
				)
			);
		}

		if ( $batch->status == self::STATUS_COMPLETED ) {

			$status = get_option( Ecwid_Importer::OPTION_STATUS, array( 'plan_limit' => array() ) );

			foreach($batch->responses as $response) {
				
				$params = explode( '|', $response->id );
				$type = $params[0];
				$woo_id = $params[1];

				if( $response->status == self::STATUS_FAILED ) {

					$exporter->_batch_progress['error'][] = $type;

					$message = '';
					if( isset( $response->httpStatusCode ) ) {
						$message .= $response->httpStatusCode;
					}
					if( isset( $response->httpStatusLine ) ) {
						$message .= ' ' . $response->httpStatusLine . '.';
					}
					if( isset( $response->httpBody->errorMessage ) ) {
						$message .= ' ' . $response->httpBody->errorMessage;
					}
					if( isset( $response->httpBody->errorCode ) ) {
						$message .= ' (' . $response->httpBody->errorCode . ')';
					}

					if ( !isset( $exporter->_batch_progress['error_messages'][$type][$message] ) ) {
						$exporter->_batch_progress['error_messages'][$type][$message] = [];
					}

					$error_data = array(
						'woo_id' => $woo_id,
						'woo_link' => wp_specialchars_decode(get_edit_post_link( $woo_id)),
						'name' => get_the_title( $woo_id )
					);

					$exporter->_batch_progress['error_messages'][$type][$message][] = $error_data;

					if ( $response->httpStatusCode == 402 ) {
						$status['plan_limit'][$type] = true;
					}

					continue;
				}

				if( $response->status != self::STATUS_COMPLETED ) {
					continue;
				}

				$ecwid_id = $response->httpBody->id;

				if ($type == 'create_product' ) {
					update_post_meta( $woo_id, '_ecwid_product_id', $ecwid_id );
					$exporter->save_ecwid_product_id( $woo_id, $ecwid_id );

					$exporter->_batch_progress['success'][] = $type;

					$exporter->append_task( 
						Ecwid_Importer_Task_Import_Woo_Product::build(
							array('id' => $woo_id)
						)
					);
				}

				if ($type == 'create_variation' ) {
					update_post_meta( $woo_id, '_ecwid_variation_id', $ecwid_id );
				}

			}

			update_option( Ecwid_Importer::OPTION_STATUS, $status );
		}

		if( isset( $task_data['timeout'] ) && $task_data['timeout'] > 0 ) {
			sleep( intval($task_data['timeout']) );
		}

		return $this->_result_success();
	}

	public static function build( array $data ) {
		return array(
			'type' => self::$type,
			'ticket' => $data['ticket'],
			'timeout' => isset($data['timeout']) ? $data['timeout'] : 0
		);
	}
}