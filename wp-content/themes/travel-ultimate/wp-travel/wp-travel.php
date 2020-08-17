<?php
remove_action( 'wp_travel_single_trip_after_title', 'wp_travel_single_excerpt', 1 );

remove_action( 'wp_travel_single_trip_after_header', 'wp_travel_related_itineraries', 25 );

remove_action( 'wp_travel_single_trip_after_header', 'wp_travel_frontend_trip_facts', 10 );