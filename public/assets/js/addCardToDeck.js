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


const btnsAddCard = $('.btnAddCardToDeck');
$.makeArray(btnsAddCard).forEach((item) => {
    $(item).on("click", addCardToDeck);
});