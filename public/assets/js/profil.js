const displayForm = () => {
    if($('#updateImg').hasClass('displayNone')){
        $('#updateImg').removeClass("displayNone");
        $('#updateImg').addClass("display");
        $('#btnUpdateImg').text("Cancel");
    }else{
        $('#updateImg').removeClass("display");
        $('#updateImg').addClass("displayNone");
        $('#btnUpdateImg').text("Change Picture");
    }
}


const btnNewImg = $('#btnUpdateImg');

btnNewImg.on('click', displayForm);