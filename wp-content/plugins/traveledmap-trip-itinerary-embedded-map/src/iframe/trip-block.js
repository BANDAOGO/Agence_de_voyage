import './style.scss';
import './editor.scss';

const {__} = wp.i18n; // Import __() from wp.i18n
const {registerBlockType} = wp.blocks; // Import registerBlockType() from wp.blocks
const {
	Fragment
} = wp.element;
import {
	TextControl,
	Button,
	ToggleControl,
	Panel,
	PanelBody,
	PanelRow
} from '@wordpress/components';
import {getMapLinkFromBaseUrl} from "./utils/utils";

registerBlockType('traveledmap/embedded-trip-block', {
	title: __('Embedded Trip'), // Block title.
	icon: 'location-alt', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'traveledmap', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__('Embedded Map'),
		__('TraveledMap'),
		__('Traveled Map'),
		__('Embedded'),
		__('Embed'),
	],
	attributes: {
		userId: {
			type: 'string',
			source: 'meta',
			meta: 'traveledmap_user_id',
		},
		tripId: {
			type: 'string',
			source: 'meta',
			meta: 'traveledmap_trip_id',
		},
		baseUrl: {
			type: 'string',
			source: 'meta',
			meta: 'traveledmap_trip_base_url',
		},
		mapUrl: {
			type: 'string',
		},
		showPopup: {
			type: 'boolean',
			default: true,
		},
		showPictures: {
			type: 'boolean',
			default: true,
		},
		showPicturesAtStart: {
			type: 'boolean',
			default: false,
		},
		isSticky: {
			type: 'boolean',
			default: true,
		},
		showOnPhones: {
			type: 'boolean',
			default: true,
		},
		showOnTablets: {
			type: 'boolean',
			default: true,
		},
		showOnLargeScreens: {
			type: 'boolean',
			default: true,
		},
		mapHeight: {
			type: 'string',
			default: '50%',
		},
		standardMapHeight: {
			type: 'string',
			default: '30%',
		},
		extendedMapHeight: {
			type: 'string',
			default: '60%',
		},
		marginTop: {
			type: 'number',
			default: 0,
		},
	},

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	edit: function (props) {
		const {
			attributes: {
				baseUrl, userId, tripId, showPopup, showPictures, showPicturesAtStart, mapUrl,
				isSticky, showOnPhones, showOnTablets, showOnLargeScreens, mapHeight, standardMapHeight,
				extendedMapHeight, marginTop,
			}, setAttributes
		} = props;

		const onDataChange = dataName => (data) => {
			setAttributes({[dataName]: data});
		};

		const setMapLink = () => {
			setAttributes({mapUrl: getMapLinkFromBaseUrl(baseUrl, showPopup, showPictures, showPicturesAtStart)});
		};

		const isEmpty = (field) => {
			return !(field && (!Array.isArray(field) || (Array.isArray(field) && field[0])));
		};

		const getUser = () => !isEmpty(userId) ? userId : null;

		const getTripId = () => {
			if (!isEmpty(tripId)) {
				return tripId;
			}
			return null;
		};

		const convertHeightForRendering = (height) => {
			return height.replace('%', 'VH')
		};

		return (
			<div className="traveledmap-trip-edit-block">
				<div>
					<Panel header="Map settings">
						<PanelBody
							title="Map content"
							icon="admin-site-alt"
							initialOpen={true}
						>
							<PanelRow>
								<p className="mb-0 note">
									<strong>User id:</strong>&nbsp;
									{
										getUser() || 'You need to fill the user id you want to use in the editor\'s sidebar, save the post and then reload'
									}
								</p>
								<p className="note">
									<strong>Trip id:</strong>&nbsp;
									{
										getTripId() || 'You need to fill the trip id you want to use in the editor\'s sidebar, save the post and then reload'
									}
								</p>
							</PanelRow>

							<PanelRow>
								<ToggleControl
									label="Show on phones"
									help={showOnPhones ? 'The map will be shown on mobile (< 576px)' : 'The map will be hidden on mobile devices'}
									checked={showOnPhones}
									onChange={() => setAttributes({showOnPhones: !showOnPhones})}
								/>
								<ToggleControl
									label="Show on tablets"
									help={showOnTablets ? 'The map will be shown on tablets (> 576px and < 768px)' : 'The map will be hidden on tablets devices'}
									checked={showOnTablets}
									onChange={() => setAttributes({showOnTablets: !showOnTablets})}
								/>
								<ToggleControl
									label="Show on larger screens"
									help={showOnLargeScreens ? 'The map will be shown on larger screens (> 768px)' : 'The map will be hidden on larger devices'}
									checked={showOnLargeScreens}
									onChange={() => setAttributes({showOnLargeScreens: !showOnLargeScreens})}
								/>
							</PanelRow>

							<PanelRow>
								<ToggleControl
									label="Show steps name"
									help={showPopup ? 'Popup with step name will be shown' : 'Popup will be show only if mouse is over the step marker'}
									checked={showPopup}
									onChange={() => setAttributes({showPopup: !showPopup})}
								/>
							</PanelRow>
							<PanelRow>
								<ToggleControl
									label="Show pictures"
									help={showPictures ? 'Pictures panel will be open' : 'Pictures will be hidden'}
									checked={showPictures}
									onChange={() => setAttributes({showPictures: !showPictures})}
								/>
							</PanelRow>
							<PanelRow>
								{
									showPictures && (
										<ToggleControl
											label="Show overview pictures"
											help={showPicturesAtStart ? 'Your trip overview has pictures that will be shown' : "The overview pictures will be hidden"}
											checked={showPicturesAtStart}
											onChange={() => setAttributes({showPicturesAtStart: !showPicturesAtStart})}
										/>
									)
								}
							</PanelRow>

							<PanelRow>
								<Button isPrimary onClick={setMapLink} className="ml-auto">
									Validate
								</Button>
							</PanelRow>
						</PanelBody>
						<PanelBody
							title="Map settings"
							icon="admin-settings"
							initialOpen={true}
						>
							<PanelRow>
								<TextControl
									label="Map height (when it's not sticky)"
									value={mapHeight}
									onChange={onDataChange('mapHeight')}
									help="Height can be written in pixels (px) or percents of the screen's height (%). i.e: 200px or 50%"
									className="input-100"
								/>
							</PanelRow>


							<PanelRow>
								<ToggleControl
									label="Map is sticky"
									help={isSticky ? 'The map will be visible on top of the screen while scrolling' : 'The map will be fixed and won\'t move'}
									checked={isSticky}
									onChange={() => setAttributes({isSticky: !isSticky})}
									className="mt-5"
								/>
							</PanelRow>
							{
								isSticky && (
									<Fragment>
										<PanelRow>
											<TextControl
												label="Map height when the map is sticky and not extended"
												value={standardMapHeight}
												onChange={onDataChange('standardMapHeight')}
												help="Height can be written in pixels (px) or percents of the screen's height (%). i.e: 200px or 50%"
												className="input-100"
											/>
										</PanelRow>

										<PanelRow>
											<TextControl
												label="Map height when the map is sticky and extended"
												value={extendedMapHeight}
												onChange={onDataChange('extendedMapHeight')}
												help="Height can be written in pixels (px) or percents of the screen's height (%). i.e: 200px or 50%"
												className="input-100"
											/>
										</PanelRow>

										<PanelRow>
											<TextControl
												type="number"
												label="Top margin (Space between the top of the screen and the map when it's sticky)"
												value={marginTop}
												onChange={onDataChange('marginTop')}
												help="Height can be written only in pixels (px). You don't need to write the unit. i.e: 20"
												className="input-100"
											/>
										</PanelRow>
									</Fragment>
								)
							}
						</PanelBody>
					</Panel>
				</div>
				{
					mapUrl && (
						<div>
							<iframe className="map-iframe traveledmap-reference-iframe" src={mapUrl} frameBorder="0" allow="fullscreen" style={{ height: convertHeightForRendering(mapHeight) }}/>
						</div>
					)
				}
			</div>
		);
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	save: () => null,
});
