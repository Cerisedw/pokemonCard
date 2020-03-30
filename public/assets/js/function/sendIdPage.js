import {constructList} from './constructList';

const pageChangeDisplay = (idPage, pageMax) => {
    $('.pagination a').removeClass("active");
    $(`#page${idPage}`).addClass("active");
    if(idPage === 1) {
        $('#back').css('display', 'none');
        $('#after').css('display', 'block');
    }else if(idPage === pageMax){
        $('#after').css('display', 'none');
        $('#back').css('display', 'block');
    }
    else{
        $('#after').css('display', 'block');
        $('#back').css('display', 'block');
    }
};


const getIdTarget = (e) => {
    let targetId;
    if(e.target.id === "back"){
        const idNoSlice = $('.active').attr('id');
        targetId = parseInt(idNoSlice.slice(4)) - 1;
    }else if(e.target.id === "after"){
        const idNoSlice2 = $('.active').attr('id');
        targetId = parseInt(idNoSlice2.slice(4)) + 1;
    }else {
        targetId = parseInt(e.target.id.slice(4));
    }
    return targetId;
};

export const sendIdPage = (e) => {
    const form = new FormData();
    const maxPage = parseInt(($('.pagination').attr('id')).slice(3));
    const idTarget = getIdTarget(e);
    form.append('page', idTarget);
    axios.post("{{ path ('getAllByPage') }}", form)
    .then((res) => {
        pageChangeDisplay(idTarget, maxPage);
        constructList(res.data);
    }).catch((error) => console.log(error));
};