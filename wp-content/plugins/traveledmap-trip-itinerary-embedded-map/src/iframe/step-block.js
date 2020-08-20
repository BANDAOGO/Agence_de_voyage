import './style.scss';
import './editor.scss';

const {__} = wp.i18n; // Import __() from wp.i18n
const {registerBlockType} = wp.blocks; // Import registerBlockType() from wp.blocks
const {
	Fragment
} = wp.element;

import {
	Spinner,
	SelectControl,
} from '@wordpress/components';

registerBlockType('traveledmap/embedded-trip-step-block', {
	title: __('Step scroll anchor'), // Block title.
	icon: 'location',
	category: 'traveledmap',
	keywords: [
		__('Embedded Trip Step'),
		__('Embed'),
		__('Step'),
		__('Trip'),
		__('City'),
		__('Place'),
		__('Scroll'),
		__('Anchor'),
	],
	attributes: {
		tripStepsJson: {
			type: 'string',
			source: 'meta',
			meta: 'traveledmap_trip_steps',
		},
		tripSteps: {
			type: 'string',
		},
		location: {
			type: 'string',
		},
	},
	edit: function (props) {
		const {
			attributes: {location, tripStepsJson, tripSteps}, setAttributes
		} = props;

		if (!tripSteps && tripStepsJson) {
			console.log({ tripStepsJson });
			const tripSteps = JSON.parse(JSON.parse(tripStepsJson));
			if(tripSteps) {
				setAttributes({
					tripSteps: tripSteps,
					location: location && location.length > 0 ? location : Object.keys(tripSteps)[0]
				});
			} else {
				console.warn('Trip steps was not defined', tripSteps, tripStepsJson)
			}
		}

		return !tripSteps ? (
			<div className="flex-center">
				<Spinner/>
			</div>
		) : (
			<div>
				<SelectControl
					label="Choose the step the map should move on when reaching this section of the post"
					value={location}
					options={Object.keys(tripSteps).map((hash) => ({
						label: tripSteps[hash],
						value: hash,
					}))}
					onChange={(newLocation) => setAttributes({location: newLocation})}
				/>
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
	save: function (props) {
		const { attributes: { location } } = props;
		return (
			<div className="traveledmap-trip-anchor" id={location} />
		);
	},
});
