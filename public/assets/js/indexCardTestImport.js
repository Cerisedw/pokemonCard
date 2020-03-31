import { sendId } from "./function/sendId";
import { sendIdPage } from "./function/sendIdPage";


const x = document.getElementsByTagName('button');

for(let i = 0; i < x.length; i++){
    x[i].addEventListener("click", sendId);
}

const a = document.getElementsByTagName('a');
for(let i = 0; i<a.length; i++){
    a[i].addEventListener("click", sendIdPage);
}

console.log('toto');