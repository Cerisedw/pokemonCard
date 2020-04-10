
const constructList = (arr, deckid) => {
    $('#content').empty();
    console.log(arr);
    arr.forEach((item)=>{
        const url = Routing.generate('cardInfo', {'id': item.id});
        $('#content').append($(`<div class="cardWithBtn">
                <a href="${url}"><img id="${item.id}" src="${item.imageUrl}" /></a>
                <a id="card${item.id} deck${deckid}" class="btnAddCardToDeck waves-effect waves-light btn">Add</a>
            </div>
        `));
    });
}

// $(`<div class="cardWithBtn">
//         <a href="${url}"><img id="${item.id}" src="${item.imageUrl}" /></a>
//         <a id="card${item.id} deck${deckid}" class="btnAddCardToDeck waves-effect waves-light btn btnDelete">Delete</a>
//         <a id="card${item.id} deck${deckid}" class="btnAddCardToDeck waves-effect waves-light btn">Add</a>
//     </div>
// `);

const pageChangeDisplay = (idPage, pageMax) => {
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


const getIdTarget = (e) => {
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

const sendIdPage = (e, deckid) => {
    const form = new FormData();
    const maxPage = parseInt(($('.pagination').attr('id')).slice(3));
    const idTarget = getIdTarget(e);
    if(maxPage >= idTarget && idTarget != 0){
        form.append('page', idTarget);
        let url = Routing.generate('getAllByPage');
        axios.post(url, form)
        .then((res) => {
            pageChangeDisplay(idTarget, maxPage);
            constructList(res.data, deckid);
        }).catch((error) => console.log(error));
    }
};

const sendId = (e, deckid) => {
    const form = new FormData();
    form.append('typeId', e.target.id);
    let url = Routing.generate('getByTypeId');
    axios.post(url, form)
    .then((res) => {
        constructList(res.data, deckid);
        // $('.pagination').css("display","none");

    })
    .catch((error) => console.log(error));
};

const idDeck = $('#deckActuel').attr('value');


const abutton = $('.listbutton a');
$.makeArray(abutton).forEach((item) => {
    $(item).on("click", (item) => sendId(item, idDeck));
});


const li = $('.pagination li');
$.makeArray(li).forEach((item) => {
    $(item).on("click", (item) => sendIdPage(item, idDeck));
});

$('.dropdown-trigger').dropdown();

