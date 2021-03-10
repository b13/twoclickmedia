document.onreadystatechange = function () {
	const selector = '.JS_twoclickmedia';
	const infoselector = '.JS_twoclickmedia-info';
	const infoselectorhideclass = 'twoclickmedia__info--hide';
	const iframeselector = '.JS_twoclickmedia-iframe';
	const iframeselectorshowclass = 'twoclickmedia__iframe--show';

	if (document.readyState === 'complete') {
		let twoclickmedia = document.querySelectorAll(selector);
		twoclickmedia.forEach( function (twoclickmediaelement) {
			twoclickmediaelement.addEventListener('click', function () {
				let info = this.querySelector(infoselector);
				let iframe = this.querySelector(iframeselector);
				let iframeSrc = iframe.dataset.src;

				info.classList.add(infoselectorhideclass);
				iframe.setAttribute('src', iframeSrc);
				iframe.classList.add(iframeselectorshowclass);
			});
		});
	}
};
