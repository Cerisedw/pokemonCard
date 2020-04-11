// filter + bouton ajout carte 
const constructList = (arr, deckid, listCode) => {
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

const sendIdPage = (e, deckid, listeCode) => {
    const form = new FormData();
    const maxPage = parseInt(($('.pagination').attr('id')).slice(3));
    const idTarget = getIdTarget(e);
    if(maxPage >= idTarget && idTarget != 0){
        form.append('page', idTarget);
        let url = Routing.generate('getAllByPage');
        axios.post(url, form)
        .then((res) => {
            pageChangeDisplay(idTarget, maxPage);
            constructList(res.data, deckid,listeCode);
            const btnAC = $('.btnAddCardToDeck');
            $.makeArray(btnAC).forEach((item) => {
                $(item).on("click", addCardToDeck);
            });
        }).catch((error) => console.log(error));
    }
};

const sendId = (e, deckid, listCode) => {
    const form = new FormData();
    form.append('typeId', e.target.id);
    let url = Routing.generate('getByTypeId');
    axios.post(url, form)
    .then((res) => {
        constructList(res.data, deckid, listCode);
        // $('.pagination').css("display","none");
        const btnAC2 = $('.btnAddCardToDeck');
        $.makeArray(btnAC2).forEach((item) => {
            $(item).on("click", addCardToDeck);
        });
    })
    .catch((error) => console.log(error));
};





// Methode d'ajout de carte dans le deck (soucis de bug d'import export de fichier js)

const jsonRequestAddCard = (iddeck, idcard, evtarget) => {
    const form = new FormData();
    form.append('iddeck', iddeck);
    form.append('idcard', idcard);
    if($(evtarget).hasClass("btnDelete")){
        let url = Routing.generate('delete-card-to-deck');
        axios.post(url, form)
        .then((res) => {
            if (res.data === "OK"){
               $(evtarget).text("Add");
               $(evtarget).removeClass("btnDelete");
            }
        })
        .catch((error) => console.log(error));;
    }else{
        let url = Routing.generate('add-card-to-deck');
        axios.post(url, form)
        .then((res) => {
            if (res.data === "OK"){
               $(evtarget).text("Delete");
               $(evtarget).addClass("btnDelete");
            }
        })
        .catch((error) => console.log(error));;
    }
};
const addCardToDeck = (e)=>{
    // console.log(e.target);
    const arrayString = $(e.target).attr('id').split(" ");
    const cardId = parseInt(arrayString["0"].slice(4));
    const deckId = parseInt(arrayString["1"].slice(4));
    jsonRequestAddCard(deckId, cardId, e.target);
    // console.log(deckId);
    // console.log(cardId);
};


// execution du code

const idDeck = $('#deckActuel').attr('value');


const abutton = $('.listbutton a');
$.makeArray(abutton).forEach((item) => {
    $(item).on("click", (item) => {
        let url = Routing.generate('deck-get-code');
        const form = new FormData();
        form.append('iddeck', idDeck);
        axios.post(url, form)
        .then((res) => {
            sendId(item, idDeck, res.data);
        }).catch((error) => console.log(error));
    
    });
});


const li = $('.pagination li');
$.makeArray(li).forEach((item) => {
    $(item).on("click", (item) => {
        let url = Routing.generate('deck-get-code');
        const form = new FormData();
        form.append('iddeck', idDeck);
        axios.post(url, form)
        .then((res) => {
            sendIdPage(item, idDeck, res.data);
        }).catch((error) => console.log(error));

    });
});

$('.dropdown-trigger').dropdown();



const btnsAddCard = $('.btnAddCardToDeck');
$.makeArray(btnsAddCard).forEach((item) => {
    $(item).on("click", addCardToDeck);
});

