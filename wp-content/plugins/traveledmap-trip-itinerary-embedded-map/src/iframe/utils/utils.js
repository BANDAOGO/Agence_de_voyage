export const getMapLinkFromBaseUrl = (baseUrl, showPopup, showPictures, showPicturesAtStart) => {
	let link = baseUrl;
	link += `${showPopup ? '&showPopup=true' : ''}`;
	link += `${!showPictures ? '&hidePictures=true' : ''}${showPicturesAtStart ? '&showPicturesAtStart=true' : ''}`;
	link += `${showPicturesAtStart ? '&showPicturesAtStart=true' : ''}`;
	return link;
};
