<?php

require('utils/enums.php');

add_action('widgets_init', function () {
	register_widget('TraveledMap_Trip_Widget');
});

class TraveledMap_Trip_Widget extends WP_Widget
{
	const MARGIN_DEFAULT = 20;
	const MAP_HEIGHT_DEFAULT = "300px";

	public function __construct()
	{
		$widget_ops = array(
			'classname' => 'traveledMap_trip_widget',
			'description' => 'A widget to embed a trip on your blog posts',
		);
		parent::__construct('traveledMap_trip_widget', 'TraveledMap Trip', $widget_ops);
	}

	// output the widget content on the front-end
	public function widget($args, $instance)
	{
		$post = get_queried_object();
		$isDisabled = get_post_meta($post->ID, 'traveledmap_disable_widget', true);

		if (!$post || $isDisabled === "1") {
			echo '<p class="traveledmap-is-hidden">Couldnt find the current post</p>';
			return;
		}


		$mapUrl = get_post_meta($post->ID, 'traveledmap_trip_base_url', true);

		if (!$mapUrl || strlen($mapUrl) === 0) {
			echo '<p class="traveledmap-is-hidden">Couldnt find the map url for post id ' . $post->ID . '</p>';
			return;
		}

		$notExtendedShowSteps = $instance['not_extended_show_steps'];
		$extandable = self::instanceVarToBool($instance, 'extandable');
		$extendableClass = $extandable ? '' : ' not-extandable';

		$mapUrl .= '&clusteringRadius=0';
		$mapUrl .= '&hidePictures=true';
		$mapUrl .= '&hideAttr=true';
		$mapUrl .= '&hideZoom=true';
		$mapUrl .= '&isWidget=true';
		$mapUrl .= $notExtendedShowSteps ? '&showPopup=true' : '';

		$showOnDevices = 'traveledmap-trip-breakpoints';
		$showOnDevices .= $instance['show_on_phones'] ? ' ' . DeviceScreensEnum::PHONES : '';
		$showOnDevices .= $instance['show_on_tablets'] ? ' ' . DeviceScreensEnum::TABLETS : '';
		$showOnDevices .= $instance['show_on_large_screens'] ? ' ' . DeviceScreensEnum::LARGE_SCREENS : '';

		echo '<div class="' . $showOnDevices . '">';
		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}

		echo '
			<div class="traveledmap-trip-widget-wrapper">
				<div class="traveledmap-trip-widget-map-container">
					<div class="traveledmap-trip-widget-map-content' . $extendableClass . '">
						' . self::getLoader() . '
						<iframe frameborder="0" allow="fullscreen" class="traveledmap-trip-widget-map" data-src="' . esc_url($mapUrl) . '" style="display: none"></iframe>
						<div class="traveledmap-trip-widget-overlay" onclick="window.traveledMapToggleMap(\'' . $this->id . '\')">
							' . self::getExpandIcon() . '
						</div>
					</div>
				</div>
			</div>
		';

		echo $this->getScript($instance, $post->ID);

		echo $this->getStyle($instance);

		echo $args['after_widget'];

		echo '</div>';
	}

	// output the option form field in admin Widgets screen
	public function form($instance)
	{
		$thisWidgetRandomId = rand(0, 10000000);
		$title = !empty($instance['title']) ? esc_attr($instance['title']) : '';
		$titleId = esc_attr($this->get_field_id('title'));
		$titleName = esc_attr($this->get_field_name('title'));
		$label = esc_attr(translate("Title", "text_domain"));

		$isStickyName = esc_attr($this->get_field_name('is_sticky'));
		$isStickyValue = esc_attr(self::instanceVarToChecked($instance, 'is_sticky'));

		$showOnPhoneName = esc_attr($this->get_field_name('show_on_phones'));
		$showOnPhonesValue = esc_attr(self::instanceVarToChecked($instance, 'show_on_phones'));
		$showOnTabletsName = esc_attr($this->get_field_name('show_on_tablets'));
		$showOnTabletsValue = esc_attr(self::instanceVarToChecked($instance, 'show_on_tablets'));
		$showOnLargeScreensName = esc_attr($this->get_field_name('show_on_large_screens'));
		$showOnLargeScreensValue = esc_attr(self::instanceVarToChecked($instance, 'show_on_large_screens'));

		$mapHeightName = esc_attr($this->get_field_name('map_height'));
		$mapHeightValue = isset($instance['map_height']) ? esc_attr($instance['map_height']) : self::MAP_HEIGHT_DEFAULT;

		$extendableName = esc_attr($this->get_field_name('extandable'));
		$extendableValue = esc_attr(self::instanceVarToChecked($instance, 'extandable'));
		$extendedTopName = esc_attr($this->get_field_name('extended_top'));
		$extendedTopValue = esc_attr(self::instanceVarToChecked($instance, 'extended_top'));
		$extendedRightName = esc_attr($this->get_field_name('extended_right'));
		$extendedRightValue = esc_attr(self::instanceVarToChecked($instance, 'extended_right'));
		$extendedBottomName = esc_attr($this->get_field_name('extended_bottom'));
		$extendedBottomValue = esc_attr(self::instanceVarToChecked($instance, 'extended_bottom'));
		$extendedLeftName = esc_attr($this->get_field_name('extended_left'));
		$extendedLeftValue = esc_attr(self::instanceVarToChecked($instance, 'extended_left'));

		$marginTopName = esc_attr($this->get_field_name('margin_top'));
		$marginTopValue = isset($instance['margin_top']) ? esc_attr($instance['margin_top']) : self::MARGIN_DEFAULT;
		$marginRightName = esc_attr($this->get_field_name('margin_right'));
		$marginRightValue = isset($instance['margin_right']) ? esc_attr($instance['margin_right']) : self::MARGIN_DEFAULT;
		$marginBottomName = esc_attr($this->get_field_name('margin_bottom'));
		$marginBottomValue = isset($instance['margin_bottom']) ? esc_attr($instance['margin_bottom']) : self::MARGIN_DEFAULT;
		$marginLeftName = esc_attr($this->get_field_name('margin_left'));
		$marginLeftValue = isset($instance['margin_left']) ? esc_attr($instance['margin_left']) : self::MARGIN_DEFAULT;

		$notExtendedShowStepsName = esc_attr($this->get_field_name('not_extended_show_steps'));
		$notExtendedShowStepsValue = esc_attr(self::instanceVarToChecked($instance, 'not_extended_show_steps'));
		$extendedShowStepsName = esc_attr($this->get_field_name('extended_show_steps'));
		$extendedShowStepsValue = esc_attr(self::instanceVarToChecked($instance, 'extended_show_steps'));
		$extendedShowPicturesName = esc_attr($this->get_field_name('extended_show_pictures'));
		$extendedShowPicturesValue = esc_attr(self::instanceVarToChecked($instance, 'extended_show_pictures'));

		$extendedWrapperClass = $extendableValue === "checked" ? '' : 'is-hidden';

		echo '
			<p>
				<h3>Widget</h3>
				<label for="' . $titleId . '"><strong>' . $label . '</strong></label>
				<input type="text" id="' . $titleId . '" name="' . $titleName . '" value="' . $title . '" class="widefat" maxlength="40">
			</p>
		';

		echo '
			<p>
				<input type="checkbox" name="' . $showOnPhoneName . '" ' . $showOnPhonesValue . '>
				<label for="' . $showOnPhoneName . '">Show on phones</label>,&nbsp;
				<input type="checkbox" name="' . $showOnTabletsName . '" ' . $showOnTabletsValue . '>
				<label for="' . $showOnTabletsName . '">Show on tablets</label>,&nbsp;
				<input type="checkbox" name="' . $showOnLargeScreensName. '" ' . $showOnLargeScreensValue . '>
				<label for="' . $showOnLargeScreensName . '">Show on larger screens</label> <br />
				<small>
					You can decides on which type of device the widget will show up.
				</small>
			</p>
			<p>
				<label>Map height (in pixels or percentage)</label>
				<input type="text" name="' . $mapHeightName . '" value="' . $mapHeightValue . '" class="widefat" maxlength="10">
				<small>
					You can specify height in pixels of percentage. i.e: 500px or 60%<br />
					Percentage are relative to screen\'s height.
				</small>
			</p>
			<p>
				<input type="checkbox" name="' . $isStickyName . '" ' . $isStickyValue . '>
				<label>Widget is sticky</label> <br />
				<small>
					Sticky means that the widget will stay fixed on the screen while user scroll,
					to allow him to see the map whereever his current scroll is on the blog post.
				</small>
			</p>
			<hr />
		';

		echo '
			<p>
				<h3>Map not extended</h3>
			  	<input type="checkbox" name="' . $notExtendedShowStepsName . '" ' . $notExtendedShowStepsValue . '>
				<label>Show steps</label>
			</p>
			<hr />
		';

		echo '
			<p>
				<h3>Map extended</h3>
				<input type="checkbox" name="' . $extendableName . '" ' . $extendableValue . ' onclick="window.toggleExtendOptions[\'' . $thisWidgetRandomId . '\']()">
				<label>Can be expanded (to a large map, using options bellow)</label> <br />
			</p>
		';

		echo '
			<div id="tm-extend-options-wrapper-' . $thisWidgetRandomId . '" class="tm-extend-options-wrapper ' . $extendedWrapperClass . '">
				<p>
					<strong>Extend options</strong><br />
					<input type="checkbox" name="' . $extendedShowStepsName . '" ' . $extendedShowStepsValue . '>
					<label>Show steps</label><br />
					<input type="checkbox" name="' . $extendedShowPicturesName . '" ' . $extendedShowPicturesValue . '>
					<label>Show pictures</label><br />
				</p>

				<p>
					<strong>Top</strong><br />
					<input type="checkbox" name="' . $extendedTopName . '" ' . $extendedTopValue . '>
					<label>Extend to the top</label> <br />
					<label>Top margin (in pixels)</label>
					<input type="number" name="' . $marginTopName . '" value="' . (int)$marginTopValue . '" class="widefat">
				</p>

				<p>
					<strong>Right</strong><br />
					<input type="checkbox" name="' . $extendedRightName . '" ' . $extendedRightValue . '>
					<label>Extend to the right</label><br />
					<label>Right margin (in pixels)</label>
					<input type="number" name="' . $marginRightName . '" value="' . (int)$marginRightValue . '" class="widefat">
				</p>

				<p>
					<strong>Bottom</strong><br />
					<input type="checkbox" name="' . $extendedBottomName . '" ' . $extendedBottomValue . '>
					<label>Extend to the bottom</label><br />
					<label>Bottom margin (in pixels)</label>
					<input type="number" name="' . $marginBottomName . '" value="' . (int)$marginBottomValue . '" class="widefat">
				</p>

				<p>
					<strong>Left</strong><br />
					<input type="checkbox" name="' . $extendedLeftName . '" ' . $extendedLeftValue . '>
					<label>Extend to the left</label><br />
					<label>Left margin (in pixels)</label>
					<input type="number" name="' . $marginLeftName . '" value="' . (int)$marginLeftValue . '" class="widefat">
				</p>

				<p>
					<strong>Help</strong>
					Margins: Space between the extended map and the screen\'s border, set in pixels (px)
					<br/>
				</p>
			</div>
		';

		echo '
			<style>
				.mt-20 {
					margin-top: 20px;
				}
				.mt-30 {
					margin-top: 30px;
				}
				.mb-0 {
					margin-bottom: 0;
				}
				.mt-0 {
					margin-top: 0;
				}
				.tm-extend-options-wrapper.is-hidden {
					display: none;
				}
			</style>

			<script>
				(function() {
				    const randomId = "' . $thisWidgetRandomId . '";
					const extendOptionsWrapperEl = document.getElementById(`tm-extend-options-wrapper-${randomId}`);
					if(!window.toggleExtendOptions) {
						window.toggleExtendOptions = {};
					}
					window.toggleExtendOptions[randomId] = function() {
					  if(extendOptionsWrapperEl.classList.contains("is-hidden")) {
						extendOptionsWrapperEl.classList.remove("is-hidden");
					  } else {
						extendOptionsWrapperEl.classList.add("is-hidden");
					  }
					};
				})();
			</script>
		';
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (isset($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
		$instance['margin_top'] = (isset($new_instance['margin_top'])) ? sanitize_text_field($new_instance['margin_top']) : self::MARGIN_DEFAULT;
		$instance['margin_right'] = (isset($new_instance['margin_right'])) ? sanitize_text_field($new_instance['margin_right']) : self::MARGIN_DEFAULT;
		$instance['margin_bottom'] = (isset($new_instance['margin_bottom'])) ? sanitize_text_field($new_instance['margin_bottom']) : self::MARGIN_DEFAULT;
		$instance['margin_left'] = (isset($new_instance['margin_left'])) ? sanitize_text_field($new_instance['margin_left']) : self::MARGIN_DEFAULT;
		$instance['map_height'] = (isset($new_instance['map_height'])) ? sanitize_text_field($new_instance['map_height']) : self::MAP_HEIGHT_DEFAULT;
		$instance['extandable'] = self::instanceVarToBool($new_instance, 'extandable');
		$instance['extended_top'] = self::instanceVarToBool($new_instance, 'extended_top');
		$instance['extended_right'] = self::instanceVarToBool($new_instance, 'extended_right');
		$instance['extended_bottom'] = self::instanceVarToBool($new_instance, 'extended_bottom');
		$instance['extended_left'] = self::instanceVarToBool($new_instance, 'extended_left');
		$instance['is_sticky'] = self::instanceVarToBool($new_instance, 'is_sticky');
		$instance['show_on_phones'] = self::instanceVarToBool($new_instance, 'show_on_phones');
		$instance['show_on_tablets'] = self::instanceVarToBool($new_instance, 'show_on_tablets');
		$instance['show_on_large_screens'] = self::instanceVarToBool($new_instance, 'show_on_large_screens');
		$instance['not_extended_show_steps'] = self::instanceVarToBool($new_instance, 'not_extended_show_steps');
		$instance['extended_show_steps'] = self::instanceVarToBool($new_instance, 'extended_show_steps');
		$instance['extended_show_pictures'] = self::instanceVarToBool($new_instance, 'extended_show_pictures');

		$instance = $this->checkInputs($instance);

		return $instance;
	}

	private static function instanceVarToChecked($instance, $varName)
	{
		return self::instanceVarToBool($instance, $varName) ? 'checked' : '';
	}

	private static function instanceVarToBool($instance, $varName)
	{
		return isset($instance[$varName]) && (($instance[$varName]) || $instance[$varName] === 1);
	}

	private static function getExpandIcon()
	{
		return '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="expand" class="svg-inline--fa fa-expand fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M0 180V56c0-13.3 10.7-24 24-24h124c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H64v84c0 6.6-5.4 12-12 12H12c-6.6 0-12-5.4-12-12zM288 44v40c0 6.6 5.4 12 12 12h84v84c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12V56c0-13.3-10.7-24-24-24H300c-6.6 0-12 5.4-12 12zm148 276h-40c-6.6 0-12 5.4-12 12v84h-84c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h124c13.3 0 24-10.7 24-24V332c0-6.6-5.4-12-12-12zM160 468v-40c0-6.6-5.4-12-12-12H64v-84c0-6.6-5.4-12-12-12H12c-6.6 0-12 5.4-12 12v124c0 13.3 10.7 24 24 24h124c6.6 0 12-5.4 12-12z"></path></svg>';
	}

	private function getLoader() {
		return '
			<div class="traveledmap-loader-icon-wrapper">
                <div class="traveledmap-loader-icon"></div>
                <p>Loading map...</p>
            </div>
		';
	}

	private function getScript($instance, $postId)
	{
		$widgetId = $this->id;

		$extendedTop = self::instanceVarToBool($instance, 'extended_top');
		$extendedRight = self::instanceVarToBool($instance, 'extended_right');
		$extendedBottom = self::instanceVarToBool($instance, 'extended_bottom');
		$extendedLeft = self::instanceVarToBool($instance, 'extended_left');

		$marginTop = isset($instance['margin_top']) ? esc_js($instance['margin_top']) : self::MARGIN_DEFAULT;
		$marginRight = isset($instance['margin_right']) ? esc_js($instance['margin_right']) : self::MARGIN_DEFAULT;
		$marginBottom = isset($instance['margin_bottom']) ? esc_js($instance['margin_bottom']) : self::MARGIN_DEFAULT;
		$marginLeft = isset($instance['margin_left']) ? esc_js($instance['margin_left']) : self::MARGIN_DEFAULT;

		$isSticky = self::instanceVarToBool($instance, 'is_sticky');

		$extendedShowSteps = self::instanceVarToBool($instance, 'extended_show_steps');
		$extendedShowPictures = self::instanceVarToBool($instance, 'extended_show_pictures');

		$postClasses = get_post_class('', $postId);
		$postClasses = '.' . implode('.', $postClasses);

		return '
			<script>
				(function() {
					const widgetIdInit = "' . $widgetId . '";
					const extendedTopInit = "' . $extendedTop . '" === "1";
					const extendedRightInit = "' . $extendedRight . '" === "1";
					const extendedBottomInit = "' . $extendedBottom . '" === "1";
					const extendedLeftInit = "' . $extendedLeft . '" === "1";
					const marginTopInit = parseInt("' . $marginTop . '", 10);
					const marginRightInit = parseInt("' . $marginRight . '", 10);
					const marginBottomInit = parseInt("' . $marginBottom . '", 10);
					const marginLeftInit = parseInt("' . $marginLeft . '", 10);
					const extendedShowStepsInit = "' . $extendedShowSteps . '" === "1";
					const extendedShowPicturesInit = "' . $extendedShowPictures . '" === "1";
					const isStickyInit = "' . $isSticky . '" === "1";

					const widget = document.getElementById(widgetIdInit);
					const mapContainerDiv = widget.getElementsByClassName("traveledmap-trip-widget-map-container")[0];
					const loaderWrapperDiv = widget.getElementsByClassName("traveledmap-loader-icon-wrapper")[0];
					const iframeDiv = mapContainerDiv.querySelector("iframe");

					window.traveledMapWidgetConfig = window.traveledMapWidgetConfig || [];
					window.traveledMapWidgetConfig[widgetIdInit] = {
					    extendedTop: extendedTopInit,
						extendedRight: extendedRightInit,
						extendedBottom: extendedBottomInit,
						extendedLeft: extendedLeftInit,
						marginTop: marginTopInit,
						marginRight: marginRightInit,
						marginBottom: marginBottomInit,
						marginLeft: marginLeftInit,
						isSticky: isStickyInit,
						extendedShowSteps: extendedShowStepsInit,
						extendedShowPictures: extendedShowPicturesInit,
						isExtended: false,
					};

					console.debug("[TraveledMap_widget] started to init", window.traveledMapWidgetConfig[widgetIdInit]); // TODO

					if(window.traveledMapIframes && Array.isArray(window.traveledMapIframes)) {
					  window.traveledMapIframes.push(iframeDiv);
					} else {
					  window.traveledMapIframes = [iframeDiv];
					}

					const createSticky = (currentWidgetId) => {
					  console.debug("[TraveledMap_widget], is sticky", window.traveledMapWidgetConfig[currentWidgetId].isSticky);
					  if(window.traveledMapWidgetConfig[currentWidgetId].isSticky) {
					    window.traveledMapStickyEl = window.traveledMapStickyEl || [];
					    // console.log("Will create or enable", currentWidgetId, window.traveledMapStickyEl);
					    if(window.traveledMapStickyEl[currentWidgetId]) {
					      	window.traveledMapStickyEl[currentWidgetId].enable();
					    } else {
							window.traveledMapStickyEl[currentWidgetId] = new Sticky(`#${currentWidgetId} .traveledmap-trip-widget-map-container`, { wrap: true });
					    }
					  }
					};

					if(!window.traveledMapToggleMap) {
						window.traveledMapToggleMap = (widgetIdToExpand) => {
						  	const currentWidget = document.getElementById(widgetIdToExpand);
							const currentMapContainerDiv = currentWidget.getElementsByClassName("traveledmap-trip-widget-map-container")[0];
						  	const currentIframeDiv = currentMapContainerDiv.querySelector("iframe");
							if(window.traveledMapWidgetConfig[widgetIdToExpand].isExtended) {
								reduceMap(currentMapContainerDiv, currentIframeDiv, widgetIdToExpand);
							} else {
								expandMap(currentMapContainerDiv, currentIframeDiv, widgetIdToExpand);
							}
						};
					}

					const setMapToReducedSize = (currentMapContainerDiv) => {
					  currentMapContainerDiv.style.position = "relative";
					  currentMapContainerDiv.style.top = "auto";
					  currentMapContainerDiv.style.right = "auto";
					  currentMapContainerDiv.style.bottom = "auto";
					  currentMapContainerDiv.style.left = "auto";
					  currentMapContainerDiv.style.height = null;
					  currentMapContainerDiv.style.width = "auto";
					};

					const reduceMap = (currentMapContainerDiv, currentIframeDiv, currentWidgetId) => {
					  setMapToReducedSize(currentMapContainerDiv);
					  const { extendedShowSteps, extendedShowPictures } = window.traveledMapWidgetConfig[currentWidgetId];
					  window.traveledMapWidgetConfig[currentWidgetId].isExtended = false;

					  currentIframeDiv.contentWindow.postMessage({ type: "mapHasBeenReduced", detail: { extendedShowSteps, extendedShowPictures }}, "*");

					  createSticky(currentWidgetId);
					};

					const setMapSizeToExtendedSize = (currentMapContainerDiv, currentWidgetId) => {
					  const rect = currentMapContainerDiv.getBoundingClientRect();
					  const viewportWidth = window.innerWidth;
					  const viewportHeight = window.innerHeight;

					  const { extendedTop, extendedRight, extendedBottom, extendedLeft, marginTop, marginRight, marginBottom, marginLeft } = window.traveledMapWidgetConfig[currentWidgetId];

					  let height = rect.height - (marginTop + marginBottom);
					  let width = rect.width - (marginLeft + marginRight);

					  currentMapContainerDiv.style.position = "fixed";

					  if(extendedTop) {
						currentMapContainerDiv.style.top = `${marginTop}px`;
						height += rect.top;
					  }
					  if(extendedBottom) {
						currentMapContainerDiv.style.bottom = `${marginBottom}px`;
						height += viewportHeight - rect.bottom;
					  }
					  if(!extendedTop && !extendedBottom) {
					    currentMapContainerDiv.style.top = `${rect.top}px`;
					    height += marginTop + marginBottom; // Because we have to keep the same height
					  }

					  if(extendedLeft) {
						currentMapContainerDiv.style.left = `${marginLeft}px`; // 0 + margin
						width += rect.left;
					  }
					  if(extendedRight) {
						currentMapContainerDiv.style.right = `${marginRight}px`;
						width += viewportWidth - rect.right;
					  }
					  if(!extendedLeft && !extendedRight) {
					    currentMapContainerDiv.style.left = `${rect.left}px`;
					    width += marginLeft + marginRight; // Because we have to keep the same width
					  }
					  currentMapContainerDiv.style.height = `${height}px`;
					  currentMapContainerDiv.style.width = `${width}px`;
					};

					const expandMap = (currentMapContainerDiv, currentIframeDiv, widgetIdToExpand) => {
					  console.debug("[TraveledMap_widget] Will destroy ", widgetIdToExpand, window.traveledMapStickyEl);
					  if(window.traveledMapStickyEl && window.traveledMapStickyEl[widgetIdToExpand]) {
						  window.traveledMapStickyEl[widgetIdToExpand].disable();
					  }
					  setMapSizeToExtendedSize(currentMapContainerDiv, widgetIdToExpand);
					  window.traveledMapWidgetConfig[widgetIdToExpand].isExtended = true;

					  const { extendedShowSteps, extendedShowPictures } = window.traveledMapWidgetConfig[widgetIdToExpand];
					  window.setTimeout(() => {
					  	currentIframeDiv.contentWindow.postMessage({ type: "mapHasBeenExtended", detail: { extendedShowSteps, extendedShowPictures }}, "*");
					  });
					};

					const listenToResizeRequest = () => {
					  window.addEventListener("message", (event) => {
					  	console.debug("[TraveledMap_widget] received event", event);
						if(!event || !event.data || !event.data.type) {
							console.error("[TraveledMap_widget] received event without type");
						}

						if(event.data.type === "needResize") {
						  window.setTimeout(onResize, 500);
						}
					  });
					};

					window.addEventListener("DOMContentLoaded", () => {
						console.debug("[TraveledMap_widget] start to listen to DOMContentLoaded", document.getElementById(widgetIdInit));
						createSticky(widgetIdInit);

						window.setTimeout(() => {
							loaderWrapperDiv.style.display = "none";
							iframeDiv.style.display = "inline";
							document.dispatchEvent(new CustomEvent("TraveledMapShowIframeConditionally"));
						}, 2000);
						listenToResizeRequest();
					});


					const onResize = () => {
					  if(window.traveledMapWidgetConfig[widgetIdInit].isExtended) {
					  	  setMapToReducedSize(mapContainerDiv);
					  	  window.traveledMapWidgetConfig[widgetIdInit].isExtended = false;
						  setMapSizeToExtendedSize(mapContainerDiv, widgetIdInit);
						  window.traveledMapWidgetConfig[widgetIdInit].isExtended = true;
					  }
					};

					window.onresize = () => {
					  onResize();
					}
				})();
			</script>

			' . getScrollAnchorScript() . '

			' . listenToIframeLocationChanged() . '

			' . checkIframeShouldShow(false) .'
		';
	}

	public function getStyle($instance)
	{
		$mapHeight = isset($instance['map_height']) ? esc_attr($instance['map_height']) : self::MAP_HEIGHT_DEFAULT;
		$mapHeight = str_replace("%", "VH", $mapHeight);
		$heightString = "height: " . $mapHeight . ';';

		return '
			<style>
				.traveledmap-trip-widget-wrapper {
					' . $heightString . '
				}
				.traveledmap-trip-widget-wrapper .traveledmap-trip-widget-map-container {
					' . $heightString . '
				}
				.traveledmap-loader-icon-wrapper {
					flex-direction: column;
					display: flex;
					justify-content: center;
					align-items: center;
					min-height: 200px;
				}
				.traveledmap-loader-icon-wrapper .traveledmap-loader-icon {
                  display: inline-block;
                  width: 50px;
                  height: 50px;
                  border: 3px solid rgba(76,76,76,.3);
                  border-radius: 50%;
                  border-top-color: #404040;
                  animation: tm-spin-anim 1s ease-in-out infinite;
                  -webkit-animation: tm-spin-anim 1s ease-in-out infinite;
                }
                .traveledmap-loader-icon-wrapper p {
				  margin-top: 20px;
                }

                @keyframes tm-spin-anim {
                  to { -webkit-transform: rotate(360deg); }
                }
                @-webkit-keyframes tm-spin-anim {
                  to { -webkit-transform: rotate(360deg); }
                }
			</style>
		';
	}

	private function checkInputs($instance)
	{
		if (strlen($instance['title']) > 40) {
			$instance['title'] = '';
		}
		if (!$this->isHeightValueValid($instance['map_height'])) {
			$instance['map_height'] = '';
		}
		$instance['margin_top'] = intval($instance['margin_top']);
		$instance['margin_right'] = intval($instance['margin_right']);
		$instance['margin_bottom'] = intval($instance['margin_bottom']);
		$instance['margin_left'] = intval($instance['margin_left']);
		return $instance;
	}

	private function isPixelsValueValid($val, $maxVal = 10000) {
		$intVal = intval(str_replace("px", "", $val));
		return strpos($val, "px") !== false && is_int($intVal) && $intVal < $maxVal;
	}

	private function isPercentValueValid($val) {
		$intVal = intval(str_replace("%", "", $val));
		return strpos($val, "%") !== false && is_int($intVal) && $intVal <= 100;
	}

	private function isHeightValueValid($val, $maxVal = 10000) {
		return $this->isPixelsValueValid($val, $maxVal) || $this->isPercentValueValid($val) || is_numeric($val);
	}

}
