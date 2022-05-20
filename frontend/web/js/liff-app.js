window.onload = function (e) {
	liff
		.init({
			liffId: "1583157145-LJYmJqrY",
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
			console.log(err)
			alert(JSON.stringify(err))
		})
	//
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
        $('#sex-name').html(response.profile.sex_name)
        $('#fullname').html(response.profile.first_name + ' ' + response.profile.last_name);
        $('#birthday').html(response.profile.birthday)
        $('#tel').html(response.profile.tel)
        $('#province').html(response.profile.province_name)
				await this.getQrList()
				this.scanQRCode()
			}
		} catch (error) {
			$("body").waitMe("hide")
			Swal.fire({
				icon: "error",
				title: "เกิดข้อผิดพลาด!",
				text: error.message,
			})
			if (error.message === "IdToken expired.") {
				liff.logout()
				window.location.reload()
			}
		}
	},
	scanQRCode: async function () {
		try {
			const result = await liff.scanCodeV2()
			const params = yii.getQueryParams(result.value)
      if(!result.value) {
        Swal.fire({
          title: "ไม่พบรหัสคิวอาร์โค้ด!",
          text: "",
          timerProgressBar: true,
          allowOutsideClick: false,
          showConfirmButton: false,
          timer: 3000
        })
        return
      }
			const code = params.code
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
          $("html, body").animate({ scrollTop: $(document).height() }, 1000);
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
		try {
			const items = await axios.get(`/v1/user/qrcode-list?userId=${user.id}`)
			$("#qr-total").html(items.length)
      $("#qr-list-item").find('.col-sm-2').remove()
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

$(window).load(function() {
  $("html, body").animate({ scrollTop: $(document).height() }, 1000);
});