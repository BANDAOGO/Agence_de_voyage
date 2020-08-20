<?php

function add_new_traveledmap_category($categories) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'traveledmap',
				'title' => __( 'TraveledMap', 'traveledmap' ),
			),
		)
	);
}
