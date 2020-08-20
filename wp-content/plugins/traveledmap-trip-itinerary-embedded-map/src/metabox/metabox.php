<?php

function traveledmap_register_meta_boxes()
{
	add_meta_box('traveledmap_trip_metabox', 'TraveledMap Trip', 'traveledmap_display_metabox_callback', null, 'side', 'high');
}

add_action('add_meta_boxes', 'traveledmap_register_meta_boxes');

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function traveledmap_display_metabox_callback($post)
{
	$userId = get_post_meta($post->ID, 'traveledmap_user_id', true);
	$tripId = get_post_meta($post->ID, 'traveledmap_trip_id', true);
	$tripSteps = get_post_meta($post->ID, 'traveledmap_trip_steps', true);
	$widgetDisabled = get_post_meta($post->ID, 'traveledmap_disable_widget', true);
	$showMarkersCustomization = get_post_meta($post->ID, 'traveledmap_show_markers_customization', true);

	$html = '
		<div class="components-panel__row">
			<div>
				<label for="traveledmap-user-id">User id</label>
				<input id="traveledmap-user-id" type="text" name="traveledmap-user-id" value="' . esc_html($userId) . '" maxlength="50" />
			</div>
		</div>

		<div class="components-panel__row flex-start">
			<div>
				<label for="traveledmap-trip-id">Trip id</label>
				<input id="traveledmap-trip-id" type="text" name="traveledmap-trip-id" value="' . esc_html($tripId) . '" maxlength="40" />
			</div>
			<p class="mt-5">
				<a href="https://www.traveledmap.com/share?tab=0&share=TRIP&tool=WORDPRESS_GUTENBERG" target="_blank">How to find your data?</a>
			</p>
		</div>

		<div class="components-panel__row flex-start">
			<div>
				<input id="traveledmap-show-markers-customization" value="1" type="checkbox" name="traveledmap-show-markers-customization" ' . ($showMarkersCustomization ? 'checked="true"' : ' ') . ' />
				<label for="traveledmap-show-markers-customization">Show markers customization</label>
			</div>
		</div>

		<div class="components-panel__row flex-start">
			<div>
				<input id="traveledmap-widget-disabled" value="1" type="checkbox" name="traveledmap-widget-disabled" ' . ($widgetDisabled ? 'checked="true"' : ' ') . ' />
				<label for="traveledmap-widget-disabled">Disable widget</label>
			</div>
		</div>

		<div class="components-panel__row">
			<div id="traveledmap-steps-wrapper" style="display: none;">
				<label for="traveledmap-trip-steps">Steps</label>
				<input id="traveledmap-trip-steps" type="text" name="traveledmap-trip-steps" value=\'' . $tripSteps . '\' />
			</div>

			<div id="traveledmap-metabox-state">
				<p class="tm-error-message">An error occurred: either user id or trip id is wrong</p>
				<p class="tm-warning-message">Everything\'s setup correctly, don\'t forget to save and refresh the page !</p>
				<p class="tm-success-message">Everything\'s good, you\'re ready to go !</p>
			</div>
		</div>

		<div class="components-panel__row">
			<button id="traveledmap-check-trip-button" onclick="handleData()" class="components-button is-button is-primary is-large">
				<span class="not-loading">Validate</span>
				<span class="loading">Loading ...</span>
			</button>
		</div>

		<script>
			const loadedUserId = "' . esc_js($userId) . '";
			const loadedTripId = "' . esc_js($tripId) . '";

			const handleData = () => {
			  const buttonEl = document.getElementById("traveledmap-check-trip-button");
			  buttonEl.classList.add("is-loading");
			  const userId = document.getElementById("traveledmap-user-id").value;
			  const tripId = document.getElementById("traveledmap-trip-id").value;
			  const link = `https://www.traveledmap.com/trip/${userId}/${tripId}?isWPMetaboxTest=true`;
			  const iframeEl = document.getElementById("traveledmap-steps-wrapper").appendChild(document.createElement("iframe"));
			  iframeEl.setAttribute("src", link);
			  iframeEl.classList.add("traveledmap-validation-iframe");
			  buttonEl.disabled = true;
			  buttonEl.classList.add("is-disabled");

			  window.addEventListener("message", (event) => {
			    if(!event || !event.data || !event.data.type) {
			      buttonEl.classList.remove("is-loading");
			      return;
			    }

				buttonEl.disabled = false;
				buttonEl.classList.remove("is-disabled");
			    const stateEl = document.getElementById("traveledmap-metabox-state");
			    switch (event.data.type) {
			      case "sendTripStepsHash":
			        const tripSteps = event.data.detail.steps;
				    stateEl.classList.remove("success");
				    stateEl.classList.remove("warning");
				    stateEl.classList.remove("error");
				    if(loadedTripId === tripId && loadedUserId === userId) {
					  stateEl.classList.add("success");
				    } else {
					  stateEl.classList.add("warning");
				    }
					document.getElementById("traveledmap-trip-steps").value = JSON.stringify(tripSteps).replace(/\'/g, "");
					break;
				  case "tripDoesNotExist":
				    stateEl.classList.remove("success");
				    stateEl.classList.remove("warning");
				    stateEl.classList.add("error");
				    break;
			    }
			    buttonEl.classList.remove("is-loading");
			  });
			};
		</script>
	';

	echo $html;
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function traveledmap_save_meta_box($post_id)
{
	$baseUrl = "https://www.traveledmap.com/trip";
	if (isset($_POST['traveledmap-user-id'])) {
		$userInput = $_POST['traveledmap-user-id'];
		if(strlen($userInput) > 50) {
			$userInput = "";
		}

		$userId = sanitize_text_field($_POST['traveledmap-user-id']);
		update_post_meta($post_id, 'traveledmap_user_id', $userId);
		$baseUrl .= "/$userId";
	}
	if (isset($_POST['traveledmap-trip-id'])) {
		$tripId = $_POST['traveledmap-trip-id'];
		if(strlen($tripId) > 40) {
			$tripId = "";
		}

		update_post_meta($post_id, 'traveledmap_trip_id', sanitize_text_field($tripId));
		$baseUrl .= "/$tripId?isWP=true";
		update_post_meta($post_id, 'traveledmap_trip_base_url', $baseUrl);
	}
	$widgetDisabled = false;
	if(isset($_POST['traveledmap-widget-disabled'])) {
		$widgetDisabled = $_POST['traveledmap-widget-disabled'];
		if($widgetDisabled === "1" || $widgetDisabled === 1 || $widgetDisabled === 'on' || $widgetDisabled === 'yes') {
			$widgetDisabled = true;
		}
	}
	update_post_meta($post_id, 'traveledmap_disable_widget', $widgetDisabled);

	$showMarkersCustomization = false;
	if(isset($_POST['traveledmap-show-markers-customization'])) {
		$showMarkersCustomization = $_POST['traveledmap-show-markers-customization'];
		if($showMarkersCustomization === "1" || $showMarkersCustomization === 1 || $showMarkersCustomization === 'on' || $showMarkersCustomization === 'yes') {
			$showMarkersCustomization = true;
			$baseUrl .= "&customizeMarkers=true";
			update_post_meta($post_id, 'traveledmap_trip_base_url', $baseUrl);
		}
	}
	update_post_meta($post_id, 'traveledmap_show_markers_customization', $showMarkersCustomization);

	if (isset($_POST['traveledmap-trip-steps'])) {
		update_post_meta($post_id, 'traveledmap_trip_steps', sanitize_text_field($_POST['traveledmap-trip-steps']));
	}
}

add_action('save_post', 'traveledmap_save_meta_box');


register_post_meta('', 'traveledmap_user_id', array(
	'show_in_rest' => true,
	'type' => 'string'
));

register_post_meta('', 'traveledmap_trip_id', array(
	'show_in_rest' => true,
	'type' => 'string'
));

register_post_meta('', 'traveledmap_trip_base_url', array(
	'show_in_rest' => true,
	'type' => 'string'
));

register_post_meta('', 'traveledmap_disable_widget', array(
	'show_in_rest' => true,
	'type' => 'boolean'
));

register_post_meta('', 'traveledmap_show_markers_customization', array(
	'show_in_rest' => true,
	'type' => 'boolean'
));

register_post_meta('', 'traveledmap_trip_steps', array(
	'show_in_rest' => true,
	'type' => 'string'
));


// UTILS ---------------------------------------------
function endsWith($haystack, $needle)
{
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}

	return (substr($haystack, -$length) === $needle);
}
