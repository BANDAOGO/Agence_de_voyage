<?php

require_once('utils/utils.php');

function traveledmap_render_callback($attributes)
{
	$mapUrl = $attributes !== null && isset($attributes['mapUrl']) ? esc_url($attributes['mapUrl']) : null;

	if (!$mapUrl) {
		return 'No map url';
	}

	$marginTop = isset($attributes['marginTop']) ? esc_js((int) $attributes['marginTop']) : 0;
	$mapHeightStyle = convertHeightToStyle(esc_html($attributes['mapHeight']));
	$mapStandardMapHeight = convertHeightToStyle(esc_html($attributes['standardMapHeight']));
	$mapExtendedMapHeight = convertHeightToStyle(esc_html($attributes['extendedMapHeight']));

	$mapClasses = 'traveledmap-post-map';

	$containerClass = 'wp-block-traveledmap-trip traveledmap-trip-breakpoints';
	$containerClass .= (bool) $attributes['isSticky'] ? ' map-sticky' : '';
	$containerClass .= (bool) $attributes['showOnPhones'] ? ' ' . DeviceScreensEnum::PHONES : '';
	$containerClass .= (bool) $attributes['showOnTablets'] ? ' ' . DeviceScreensEnum::TABLETS : '';
	$containerClass .= (bool) $attributes['showOnLargeScreens'] ? ' ' . DeviceScreensEnum::LARGE_SCREENS : '';

	return '
		<div class="' . $containerClass . '">
			<iframe id="traveledmap-post-map" allow="fullscreen" class="' . $mapClasses . '" data-src="' . $mapUrl . '" frameborder="0"></iframe>
			<div class="actions-wrapper flex-center">
				<button type="button" onclick="toggleShow()" class="mr-5">
					<div class="show-icon">' . getShowIcon() . '</div>
					<div class="hide-icon">' . getHideIcon() . '</div>
				</button>
				<button type="button" onclick="toggleExpand()" class="toggle-expand-button">
					<div class="expand-icon">' . getExpandIcon() . '</div>
					<div class="reduce-icon">' . getReduceIcon() . '</div>
				</button>
			</div>


			<style>
				.wp-block-traveledmap-trip iframe.traveledmap-post-map {
					' . $mapHeightStyle . ';
				}
				.wp-block-traveledmap-trip.map-sticky.is-sticky iframe.traveledmap-post-map {
					' . $mapStandardMapHeight . ';
				}
				.wp-block-traveledmap-trip.map-sticky.is-sticky.is-extended iframe.traveledmap-post-map {
					' . $mapExtendedMapHeight . ';
				}
				.wp-block-traveledmap-trip.map-sticky.is-sticky.is-hidden iframe.traveledmap-post-map {
					height: 0;
				}
			</style>

			<script>
				const marginTop = parseInt("' . $marginTop . '");
				if(window.traveledMapIframes && Array.isArray(window.traveledMapIframes)) {
				  window.traveledMapIframes.push(document.getElementById("traveledmap-post-map"));
				} else {
				  window.traveledMapIframes = [document.getElementById("traveledmap-post-map")];
				}

				document.addEventListener("DOMContentLoaded", function() {
					new Sticky(".wp-block-traveledmap-trip.map-sticky", { marginTop, stickyClass: "is-sticky", wrap: true });
				});

				const toggleExpand = () => {
				  Array.from(document.getElementsByClassName("traveledmap-post-map")).forEach((el) => {
					if(el.parentNode.classList.contains("is-extended")) {
					  el.parentNode.classList.remove("is-extended");
					} else {
					  el.parentNode.classList.add("is-extended");
					}
				  });
				};

				const toggleShow = () => {
				  Array.from(document.getElementsByClassName("traveledmap-post-map")).forEach((el) => {
					if(el.parentNode.classList.contains("is-hidden")) {
					  el.parentNode.classList.remove("is-hidden");
					} else {
					  el.parentNode.classList.add("is-hidden");
					}
				  });
				}
			</script>

			' . getScrollAnchorScript() .'

			' . listenToIframeLocationChanged() .'

			' . checkIframeShouldShow(true) .'
		</div>';
}

function convertHeight($height) {
	$height = trim($height);
	return str_replace("%", "VH", $height);
}

function convertHeightToStyle($height) {
	return "height: " . convertHeight($height) . ";";
}

function getExpandIcon() {
	return '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-double-down" class="svg-inline--fa fa-angle-double-down fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M143 256.3L7 120.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0L313 86.3c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.4 9.5-24.6 9.5-34 .1zm34 192l136-136c9.4-9.4 9.4-24.6 0-33.9l-22.6-22.6c-9.4-9.4-24.6-9.4-33.9 0L160 352.1l-96.4-96.4c-9.4-9.4-24.6-9.4-33.9 0L7 278.3c-9.4 9.4-9.4 24.6 0 33.9l136 136c9.4 9.5 24.6 9.5 34 .1z"></path></svg>';
}

function getReduceIcon()
{
	return '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-double-up" class="svg-inline--fa fa-angle-double-up fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M177 255.7l136 136c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 351.9l-96.4 96.4c-9.4 9.4-24.6 9.4-33.9 0L7 425.7c-9.4-9.4-9.4-24.6 0-33.9l136-136c9.4-9.5 24.6-9.5 34-.1zm-34-192L7 199.7c-9.4 9.4-9.4 24.6 0 33.9l22.6 22.6c9.4 9.4 24.6 9.4 33.9 0l96.4-96.4 96.4 96.4c9.4 9.4 24.6 9.4 33.9 0l22.6-22.6c9.4-9.4 9.4-24.6 0-33.9l-136-136c-9.2-9.4-24.4-9.4-33.8 0z"></path></svg>';
}

function getHideIcon()
{
	return '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="eye-slash" class="svg-inline--fa fa-eye-slash fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"></path></svg>';
}

function getShowIcon()
{
	return '<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="eye" class="svg-inline--fa fa-eye fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M288 144a110.94 110.94 0 0 0-31.24 5 55.4 55.4 0 0 1 7.24 27 56 56 0 0 1-56 56 55.4 55.4 0 0 1-27-7.24A111.71 111.71 0 1 0 288 144zm284.52 97.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400c-98.65 0-189.09-55-237.93-144C98.91 167 189.34 112 288 112s189.09 55 237.93 144C477.1 345 386.66 400 288 400z"></path></svg>';
}
