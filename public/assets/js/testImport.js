import { sendId, sendIdPage } from "./fonction/mesFonctions1.js";

const abutton = $('.listbutton a');
$.makeArray(abutton).forEach((item) => {
    $(item).on("click", sendId);
});


const li = $('.pagination li');
$.makeArray(li).forEach((item) => {
    $(item).on("click", sendIdPage);
});

$('.dropdown-trigger').dropdown();




