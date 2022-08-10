window.onload = function (e) {
	liff
		.init({
			liffId: "1552736042-KqeVvaMw",
			withLoginOnExternalBrowser: true,
		})
		.then(() => {
			if (!liff.isLoggedIn()) {
				liff.login()
			} else {
				// liff.logout()
				initializeApp()
			}
		})
		.catch((err) => {
			alert(JSON.stringify(err))
		})
	//
}

var video = document.createElement("video")
var canvasElement = document.getElementById("canvas")
var canvas = canvasElement.getContext("2d")
var loadingMessage = document.getElementById("loadingMessage")
var outputContainer = document.getElementById("output")
var outputMessage = document.getElementById("outputMessage")
var outputData = document.getElementById("outputData")

function drawLine(begin, end, color) {
	canvas.beginPath()
	canvas.moveTo(begin.x, begin.y)
	canvas.lineTo(end.x, end.y)
	canvas.lineWidth = 4
	canvas.strokeStyle = color
	canvas.stroke()
}

// Use facingMode: environment to attemt to get the front camera on phones
navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function (stream) {
	video.srcObject = stream
	video.setAttribute("playsinline", true) // required to tell iOS safari we don't want fullscreen
	video.play()
	requestAnimationFrame(tick)
})

var lastResult,
	countResults = 0

function tick() {
	loadingMessage.innerText = "⌛ Loading video..."
	if (video.readyState === video.HAVE_ENOUGH_DATA) {
		loadingMessage.hidden = true
		canvasElement.hidden = false
		outputContainer.hidden = false

		canvasElement.height = video.videoHeight
		canvasElement.width = video.videoWidth
		canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height)
		var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height)
		var code = jsQR(imageData.data, imageData.width, imageData.height, {
			inversionAttempts: "dontInvert",
		})
		if (code && code.data) {
			++countResults
			lastResult = code
			drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58")
			drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58")
			drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58")
			drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58")
			outputMessage.hidden = true
			outputData.parentElement.hidden = false
			outputData.innerText = code.data
			video.pause()
      const params = yii.getQueryParams(code.data)
			$('#card-camera').hide();
      app.saveQrcode(params.code)
		} else {
			outputMessage.hidden = false
			outputData.parentElement.hidden = true
		}
	}
	if (!lastResult) {
		requestAnimationFrame(tick)
	}
}

// Add a request interceptor
axios.interceptors.request.use(
	function (config) {
		// Do something before request is sent
		return config
	},
	function (error) {
		// Do something with request error
		return Promise.reject(error)
	}
)

// Add a response interceptor
axios.interceptors.response.use(
	(response) => {
		return _.get(response, "data", response)
	},
	(error) => {
		return Promise.reject(_.get(error, "response.data", error))
	}
)

var user, account
var restaurants = []

var app = {
	initLoading: function () {
		$("body").waitMe({
			effect: "roundBounce",
			text: "",
			bg: "rgba(255,255,255,0.7)",
			color: "#000",
			maxSize: "",
			waitTime: -1,
			textPos: "vertical",
			fontSize: "",
			source: "",
			onClose: function () {},
		})
	},
	getProfile: async function () {
		try {
			const idToken = liff.getIDToken()
			const profile = await liff.getProfile()
			// const email = liff.getDecodedIDToken().email
			let response = await axios.get(`/v1/user/me?id_token=${idToken}`)
			user = response.user
			account = response.account
			localStorage.setItem("profile", JSON.stringify(profile))

			if (profile.pictureUrl) {
				$("#picture").attr("src", profile.pictureUrl)
			}

			if (!response.account) {
				window.location.replace("/site/register")
			} else {
				$("#sex-name").html(response.profile.sex_name)
				$("#fullname").html(response.profile.first_name + " " + response.profile.last_name)
				$("#birthday").html(response.profile.birthday)
				$("#tel").html(response.profile.tel)
				$("#province").html(response.profile.province_name)
				await this.getQrList()
        $("html, body").animate({ scrollTop: $(document).height() }, 1000)
				// this.scanQRCode()
			}
		} catch (error) {
			$("body").waitMe("hide")
			Swal.fire({
				icon: "error",
				title: "เกิดข้อผิดพลาด!",
				text: error.message,
			})
      setTimeout(() => {
        liff.logout()
				window.location.reload()
      }, 1000);
			// if (error.message === "IdToken expired.") {
			// 	liff.logout()
			// 	window.location.reload()
			// }
		}
	},
	// scanQRCode: async function () {
	// 	try {
	// 		const result = await liff.scanCodeV2()
	// 		const params = yii.getQueryParams(result.value)
	// 		if (!result.value) {
	// 			Swal.fire({
	// 				title: "ไม่พบรหัสคิวอาร์โค้ด!",
	// 				text: "",
	// 				timerProgressBar: true,
	// 				allowOutsideClick: false,
	// 				showConfirmButton: false,
	// 				timer: 3000,
	// 			})
	// 			return
	// 		}
	// 		const code = params.code
	// 		Swal.fire({
	// 			title: "กรุณารอสักครู่!",
	// 			text: "",
	// 			timerProgressBar: true,
	// 			allowOutsideClick: false,
	// 			showConfirmButton: false,
	// 			didOpen: () => {
	// 				Swal.showLoading()
	// 			},
	// 		})
	// 		await axios.post(`/v1/user/save-qrcode`, {
	// 			user_id: user.id,
	// 			code: code,
	// 		})
	// 		Swal.fire({
	// 			icon: "success",
	// 			title: "ระบบได้ทำการบันทึกรายการของคุณแล้ว",
	// 			text: "",
	// 			timer: 3000,
	// 			timerProgressBar: true,
	// 			allowOutsideClick: false,
	// 			showConfirmButton: false,
	// 			willClose: () => {
	// 				$("html, body").animate({ scrollTop: $(document).height() }, 1000)
	// 			},
	// 		})
	// 		app.getQrList()
	// 	} catch (error) {
	// 		Swal.fire({
	// 			icon: "warning",
	// 			title: "ไม่สามารถสแกนคิวอาร์โค้ดได้!",
	// 			text: error.message,
	// 		})
	// 	}
	// },
	scanQr: function () {
		lastResult = null
    countResults = 0
    video.play()
    $('#card-camera').show();
    setTimeout(() => {
      $("html, body").animate({ scrollTop: parseInt($("#qr-total").offset().top) }, 1000)
      requestAnimationFrame(tick)
    }, 1000);
	},
	saveQrcode: async function (code) {
    if(!user) return
		try {
			Swal.fire({
				title: "กรุณารอสักครู่!",
				text: "",
				timerProgressBar: true,
				allowOutsideClick: false,
				showConfirmButton: false,
				didOpen: () => {
					Swal.showLoading()
				},
			})
			await axios.post(`/v1/user/save-qrcode`, {
				user_id: user.id,
				code: code,
			})
			Swal.fire({
				icon: "success",
				title: "ระบบได้ทำการบันทึกรายการของคุณแล้ว",
				text: "",
				timer: 3000,
				timerProgressBar: true,
				allowOutsideClick: false,
				showConfirmButton: false,
				willClose: () => {
					$("html, body").animate({ scrollTop: $(document).height() }, 1000)
				},
			})
			app.getQrList()
		} catch (error) {
			Swal.fire({
				icon: "warning",
				title: "ไม่สามารถสแกนคิวอาร์โค้ดได้!",
				text: error.message,
			})
		}
	},
	getQrList: async function () {
    if(!user) return
		try {
			const items = await axios.get(`/v1/user/qrcode-list?userId=${user.id}`)
			$("#qr-total").html(items.length)
			$("#qr-list-item").find(".col-sm-2").remove()
			for (let i = 0; i < items.length; i++) {
				const item = items[i]
				var template = `<div class="col-sm-2"><div class="qrcode"><i class="fa fa-qrcode"></i> ${item.qrcode_id}</div></div>`
				$("#qr-list-item").append(template)
				restaurants.push(parseFloat(item.qrcode_id))
			}
		} catch (error) {
			Swal.fire({
				icon: "error",
				title: "เกิดข้อผิดพลาด!",
				text: error.message,
			})
		}
	},
}

async function initializeApp() {
	if (!liff.isLoggedIn() && !liff.isInClient()) {
		window.alert('To get an access token, you need to be logged in. Tap the "login" button below and try again.')
	} else {
		// const accessToken = liff.getAccessToken()
		// console.log(accessToken)
		// const idToken = liff.getIDToken()
		// console.log(idToken) // print raw idToken object
		// console.log(liff.getLanguage())
		// console.log(liff.getVersion())
		// console.log(liff.isInClient())
		// console.log(liff.isLoggedIn())
		// console.log(liff.getOS())
		// console.log(liff.getLineVersion())
		await app.getProfile()
		$("body").waitMe("hide")
	}
}

app.initLoading()

$(window).load(function () {
	$("html, body").animate({ scrollTop: $(document).height() }, 1000)
})
