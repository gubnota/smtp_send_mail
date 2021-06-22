const fs = require("fs");
const nodemailer = require("nodemailer");
var contents = fs.readFileSync("../mail_template.html", { encoding: "utf-8" });
var contents = contents.replace("%OTP%", "123456");
var contents = contents.replace("%TIME%", new Date().toUTCString());
//let testAccount = await nodemailer.createTestAccount();
let testAccount = {
	host: "smtp.email.com",
	port: 465,
	secure: true, // true for 465, false for other ports
	user: "sender@email.com",
	pass: "sender_password",
};
let message = {
	from: testAccount.user,
	to: "reciever@email.com",
	subject: "Fenki word OTP code",
	text: "Your otp code is 123456",
	html: contents,
	attachments: [
		{
			filename: "Fenki_Words.jpg",
			path: "../Fenki_Words.jpg",
			cid: "Fenki_Words.jpg", //same cid value as in the html img src
		},
		// {
		// 	// use URL as an attachment
		// 	filename: "license.txt",
		// 	path: "https://raw.github.com/nodemailer/nodemailer/master/LICENSE",
		// },
	],
};

// to test before send
// let transporter = nodemailer.createTransport({
// 	streamTransport: true,
// 	newline: "windows",
// });

let transporter = nodemailer.createTransport({
	host: testAccount.host,
	port: testAccount.port,
	secure: testAccount.secure, // true for 465, false for other ports
	auth: {
		user: testAccount.user, // generated ethereal user
		pass: testAccount.pass, // generated ethereal password
	},
});

transporter.sendMail(message, (err, info) => {
	console.log(info.envelope);
	console.log(info.messageId);
	info.message.pipe(process.stdout);
});
