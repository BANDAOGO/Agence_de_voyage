<?php

function getScrollAnchorScript()
{
	return '
		<script>
			if(!window.traveledMapScrollAnchorListenerExists) { // dont include the script twice
			  	window.traveledMapScrollAnchorListenerExists = true;

			  	window.scrollListenerIsEnabledTM = true;

				const changeHashTM = (newHash) => {
					history.replaceState({}, "", newHash !== null ? "#" + newHash : null);
					const iframeWindowsTM = window.traveledMapIframes.map(el => el.contentWindow);
					iframeWindowsTM.forEach(ifrmWin => ifrmWin.postMessage({ type: "parentWindowHashChanged", detail: { hash: newHash || null }}, "*"));
				};

				let currentHashTM = "";
				let previousScrollDistanceTM = 0;
				let isScrollingDownTM = true;
				let mapElements = document.getElementsByClassName("wp-block-traveledmap-trip");
				let mapElement = mapElements && mapElements.length > 0 && mapElements[0];
				let CONVENIENT_DISTANCE_TM = mapElement ? 100 : 300;
				window.addEventListener("scroll", () => {
				  	if(!window.scrollListenerIsEnabledTM) {
				  	  return;
				  	}

				  	const mapElementHeight = mapElement ? mapElement.offsetHeight : 0;
					const currentScrollDistance = window.pageYOffset;
					isScrollingDownTM = currentScrollDistance > previousScrollDistanceTM;
					previousScrollDistanceTM = currentScrollDistance;
					let closestIndex = 0;
					let closestDistance = 1000000;
					const anchors = Array.from(document.getElementsByClassName("traveledmap-trip-anchor"));

					anchors.forEach((anchor, index) => {
						const rect = anchor.getBoundingClientRect();
						const distance = rect.top - mapElementHeight; // distance is the distance between the anchor and the bottom of the sticky map (if the sticky map is there)

						if(Math.abs(distance) < Math.abs(closestDistance)) {
							closestDistance = distance;
							closestIndex = index;
						}
					});

					let distanceThatShouldTrigger = CONVENIENT_DISTANCE_TM;

					if(distanceThatShouldTrigger > closestDistance) { // Closest distance < 200, we\'re in range to change
						if(!isScrollingDownTM) {
							if (closestDistance > 0) {
								closestIndex = closestIndex === 0 ? 0 : closestIndex - 1;
							}
						}

						const hash = anchors[closestIndex].getAttribute("id");
						if(currentHashTM !== hash) {
							changeHashTM(hash);
							currentHashTM = hash;
						}
					}

					const firstAnchor = anchors[0]; // Condition to go to step overview
					if(firstAnchor && currentHashTM !== null && currentHashTM === firstAnchor.getAttribute("id") && firstAnchor.getBoundingClientRect().top - mapElementHeight > distanceThatShouldTrigger) {
						changeHashTM(null);
						currentHashTM = null;
					}
				});
			}
		</script>
	';
}

function listenToIframeLocationChanged()
{
	return '
		<script>
			window.addEventListener("message", (evt) => {
			  if(evt.data && evt.data.type && evt.data.type === "onLocationChanged") {
			    window.scrollListenerIsEnabledTM = false;
			    const { hash } = evt.data.detail;
			    window.location.hash = hash;
			    const el = document.getElementById(hash);
			    if(el) {
					el.scrollIntoView({
					  block: "start",
					  behavior: "smooth"
					});
					window.setTimeout(() => { window.scrollListenerIsEnabledTM = true }, 1000);
			    }
			  }
			});
		</script>
	';
}

function checkIframeShouldShow($shouldShowDirectly) {
	return '
		<script>
			(() => {
			  	const PHONES = "' . DeviceScreensEnum::PHONES . '";
			  	const TABLETS = "' . DeviceScreensEnum::TABLETS . '";
			  	const LARGE_SCREENS = "' . DeviceScreensEnum::LARGE_SCREENS . '";

			  	const showElement = (el) => {
				  const iframe = el.querySelector("iframe");
				  if(iframe) {
				    el.style.display = "block";
				    document.addEventListener("TraveledMapShowIframeConditionally", () => {
				    	console.debug("[TraveledMap_widget] will display");
						iframe.setAttribute("src", iframe.getAttribute("data-src"));
				   	});
				  }
				};

				const width = window.innerWidth;
				const isPhone = width <= 576;
				const isTablet = width > 576 && width <= 768;
				const isLargeScreen = width > 768;
				Array.from(document.getElementsByClassName("traveledmap-trip-breakpoints")).forEach(el => {
				  if(
					isPhone && el.classList.contains(PHONES)
					|| isTablet && el.classList.contains(TABLETS)
					|| isLargeScreen && el.classList.contains(LARGE_SCREENS)
				  ) {
					showElement(el);
				  }
				});
			})();
			' . showIframeConditionally($shouldShowDirectly) . '
		</script>
	';
}

function showIframeConditionally($shouldShowDirectly) {
	if($shouldShowDirectly) {
		return 'document.dispatchEvent(new CustomEvent("TraveledMapShowIframeConditionally"))';
	}
	return '';
}
