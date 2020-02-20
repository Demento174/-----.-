<?php

namespace ACP\Editing\Model;

use ACP\Editing\Model;

abstract class Post extends Model {

	/**
	 * @param int   $id
	 * @param array $args
	 *
	 * @return bool
	 */
	protected function update_post( $id, array $args = array() ) {
		$args['ID'] = $id;

		$result = wp_update_post( $args );

		if ( is_wp_error( $result ) ) {
			$this->set_error( $result );

			return false;
		}

		return $result > 0;
	}

}