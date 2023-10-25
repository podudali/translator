// Get the 'deepai' package here (Compatible with browser & nodejs):
//     https://www.npmjs.com/package/deepai
// All examples use JS async-await syntax, be sure to call the API inside an async function.
//     Learn more about async-await here: https://javascript.info/async-await

// Example posting a text URL:

const deepai = require('deepai'); // OR include deepai.min.js as a script tag in your HTML

deepai.setApiKey('cbea37a8-37d4-47d1-a9ba-688999b8cf20');

(async function() {
    var resp = await deepai.callStandardApi("text2img", {
            text: "YOUR_TEXT_URL",
    });
    console.log(resp);
})()


// Example posting file picker input text (Browser only):

const deepai = require('deepai'); // OR include deepai.min.js as a script tag in your HTML

deepai.setApiKey('cbea37a8-37d4-47d1-a9ba-688999b8cf20');

(async function() {
    var resp = await deepai.callStandardApi("text2img", {
            text: document.getElementById('yourFileInputId'),
    });
    console.log(resp);
})()


// Example posting a local text file (Node.js only):
const fs = require('fs');

const deepai = require('deepai'); // OR include deepai.min.js as a script tag in your HTML

deepai.setApiKey('cbea37a8-37d4-47d1-a9ba-688999b8cf20');

(async function() {
    var resp = await deepai.callStandardApi("text2img", {
            text: fs.createReadStream("/path/to/your/file.txt"),
    });
    console.log(resp);
})()


// Example directly sending a text string:

const deepai = require('deepai'); // OR include deepai.min.js as a script tag in your HTML

deepai.setApiKey('cbea37a8-37d4-47d1-a9ba-688999b8cf20');

(async function() {
    var resp = await deepai.callStandardApi("text2img", {
            text: "YOUR_TEXT_HERE",
    });
    console.log(resp);
})()