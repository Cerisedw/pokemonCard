const constructList2 = (arr, deckid, listCode) => {
    $('#content').empty();
    arr.forEach((item)=>{
        const url = Routing.generate('cardInfo', {'id': item.id});
        if (listCode.includes(item.code)){
            $('#content').append($(`<div class="cardWithBtn">
                    <a href="${url}"><img id="${item.id}" src="${item.imageUrl}" /></a>
                    <a id="card${item.id} deck${deckid}" class="btnAddCardToDeck waves-effect waves-light btn btnDelete">Delete</a>
                </div>
            `));

        }else {
            $('#content').append($(`<div class="cardWithBtn">
                    <a href="${url}"><img id="${item.id}" src="${item.imageUrl}" /></a>
                    <a id="card${item.id} deck${deckid}" class="btnAddCardToDeck waves-effect waves-light btn">Add</a>
                </div>
            `));
        }
    });
}

const getIdTarget2 = (e) => {
    let targetId;
    if(e.target.id === "back"){
        const idNoSlice = $('.active').children().attr('id');
        targetId = parseInt(idNoSlice.slice(4)) - 1;
    }else if(e.target.id === "after"){
        const idNoSlice2 = $('.active').children().attr('id');
        targetId = parseInt(idNoSlice2.slice(4)) + 1;
    }else {
        targetId = parseInt(e.target.id.slice(4));
    }
    return targetId;
};



const pageChangeDisplay2 = (idPage, pageMax) => {
    $('.pagination li').removeClass("active");
    $(`#page${idPage}`).parent().addClass("active");
    if(idPage === 1) {
        $('#after').parent().parent().removeClass("disabled");
        $('#back').parent().parent().addClass("disabled");
    }else if(idPage === pageMax){
        $('#back').parent().parent().removeClass("disabled");
        $('#after').parent().parent().addClass("disabled");
    }
    else{
        $('#after').parent().parent().removeClass("disabled");
        $('#back').parent().parent().removeClass("disabled");
    }
};



const newPagination = (maxPage) => {
    const maxPagenmb = (maxPage === 0) ? 1 : maxPage;
    $('.pagination').empty();
    $('.pagination').append(`<li class="waves-effect disabled"><a><i class="material-icons" id='back'>chevron_left</i></a></li>`);
    for(let i = 0; i < maxPagenmb; i++){
        if(i === 0){
            $('.pagination').append(`<li class="active waves-effect"><a id='page${i + 1}'>${i + 1}</a></li>`);
        }else {
            $('.pagination').append(`<li class="waves-effect"><a id='page${i + 1}'>${i + 1}</a></li>`);
        }
    }
    $('.pagination').append(`<li class="waves-effect"><a><i class="material-icons" id='after'>chevron_right</i></a></li>`);
};


const putPaginationJs = (pageMax, idtype, iddeck, listecode) => {
    const form2 = new FormData();
    const li = $('.pagination li');
    $.makeArray(li).forEach((item) => {
        $(item).on("click", (p) => {
            const idtarget = getIdTarget2(p);
            if(pageMax >= idtarget && idtarget != 0){
                form2.append('page', idtarget);
                let url = Routing.generate('card-pagination-type', {'idtype' : idtype});
                axios.post(url, form2)
                .then((res) => {
                    pageChangeDisplay2(idtarget, pageMax);
                    constructList2(res.data, iddeck, listecode);
                    const btnAC2 = $('.btnAddCardToDeck');
                    $.makeArray(btnAC2).forEach((item) => {
                        $(item).on("click", addCardToDeck);
                    });
                })
                .catch((error) => console.log(error));
            }
        });
    });
    $('.dropdown-trigger').dropdown();
}

const iddeck = $('#deckActuel').attr('value');

const filterbtn = $('.filter');
$.makeArray(filterbtn).forEach((item) => {
    $(item).on("click", (x) => {
        const idtype = x.target.id.slice(4);
        let url = Routing.generate('deck-get-code');
        const form = new FormData();
        form.append('iddeck', iddeck);
        axios.post(url, form)
        .then((res) => {
            const listecode = res.data;
            const form3 = new FormData();
            const url3 = Routing.generate('card-maxpage-type', {'idtype': idtype});
            axios.post(url3, form3)
            .then((res) => {
                const nmbPage = res.data;
                newPagination(nmbPage);
                putPaginationJs(nmbPage, idtype, iddeck, listecode);
            })
            .catch((error) => console.log(error));
        }).catch((error) => console.log(error));


    });
});