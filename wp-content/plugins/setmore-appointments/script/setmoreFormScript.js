window.onload = function () {
	var bookingPageUrl = document.querySelector("#setmore_booking_page_url").value;

	if (bookingPageUrl && bookingPageUrl != "https://my.setmore.com" && bookingPageUrl != null && bookingPageUrl != "") {
		document.querySelector(".sm-acc-info").style.display = "block";
	}
	else {
		document.querySelector(".sm-acc-info").style.display = "none";
	}
	var optionList = document.querySelector('.sm-dropdown ul');
	document.querySelector("#dropDown").onclick = function () {
		optionList.style.display = "block ";
	}
	var langList = document.querySelectorAll('.sm-dropdown ul li');

	for (var i = 0; i < langList.length; i++) {
		langList[i].onclick = function () {
			document.querySelector(".sm-dropdown input").value = this.textContent;
			optionList.style.display = "none ";
		}
	}

	document.addEventListener("click", function (event) {
		if (event.target.className == "fa fa-sort-down" || event.target.className == "langaugeList") {
			optionList.style.display = "block ";
		} else {
			optionList.style.display = "none";
		}
	});

	document.querySelector(".btn-login").onclick = function () {
		var siteUrl = this.getAttribute("siteurl");
		var popupWindow = window.open('https://my.setmore.com/integration/wordpress/oauth?siteUrl=' + siteUrl, "_blank", "scrollbars=yes,resizable=yes,top=108,left=0,right=0,width=821,height=625,margin= 0 auto;");
		popupWindow.focus();
		var pollTimer = window.setInterval(function () {
			console.log('the popupwindow', popupWindow.location.href);
			if (popupWindow.location.href.indexOf("status=true") != -1) {
				const urlParams = new URLSearchParams(popupWindow.location.search);
				document.querySelector(".sm-acc-info").style.display = "block";
				document.querySelector("#setmore_booking_page_url").value = urlParams.get("bookingpageurl");
				window.clearInterval(pollTimer);
				popupWindow.close();
			}
		}, 1000);
	}
}



