document.addEventListener('DOMContentLoaded', (event) => {
    const account = $("#account_number");
    account.on('keyup', () => {
        const account_number = account.val();
        if (account_number.length >= 10) {
            resolveAccountNumber();
        }
    });

    $("#bank").on('change', () => {
        if (account.val() !== '' && account.val().length >= 10) {
            resolveAccountNumber();
        }
    });

    function resolveAccountNumber() {
        account.attr('readonly', true);
        let d = new FormData();

        // d.append('_token', $('#token').data('token'));
        d.append('account_number', $('#account_number').val());
        d.append('bank', $('#bank_code').val());
        d.append('_token',  $('meta[name="csrf-token"]').attr('content'));
        $.ajax({
            url: '/account/resolve',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: d,
            beforeSend: function () {
                $('#accountHelpText').html(`<span class="text-primary">Resolving account number. Please wait... <span class="fas fa-circle-notch fa-spin"></span></i>`);
            },
            success: function (response) {
                account.attr('readonly', false);

                // console.log(response);
                if (response.status === true) {
                    $('#accountHelpText').html(`<span class="text-success">Success! ${response.message}</span>`);
                    $('#account_name').val(response.data.account_name);
                    $('#bank_name').val($('#bank_code option:selected').text());
                    $('#accountSaveBtn').attr('disabled', false);
                } else {
                    $('#accountHelpText').html(`<span class="text-danger">${response.message}</span>`);
                    $('#account_name').val('');
                    $('#accountSaveBtn').attr('disabled', true);
                }
            },
            error: function (request, error) {
                account.attr('readonly', false);
                $('#accountHelpText').html(`<span class="text-danger">Sorry! an error occurred, please try again</span>`);
                $('#account_name').val('');
                $('#accountSaveBtn').attr('disabled', true);
            }
        });
    }

    function calculateDynamicPrice(){
        let currency = $("input[name='currency']:checked").val();
        let amount = $("#amount").val();
        let rate = $("#rate").val();
        let sign = 'NGN ';
        let csign = '₦';
        let dynamicAmount = 0;
        if(currency === 'NGN'){
            // Divide the amount with the rate
            const dollarFormat = Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            });
            dynamicAmount = (amount / rate);
            dynamicAmount = dollarFormat.format(dynamicAmount);
            sign = 'USD '
            csign = '$'
        }else{
            const nairaFormat = Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'NGN'
            });
            // Multiply the amount with the rate
            dynamicAmount = amount * rate;
            dynamicAmount = nairaFormat.format(dynamicAmount);
            sign = 'NGN '
            csign = '₦'
        }

            // Add to html
            $("#equiv_name").text(sign);
            $("#converted").text(`${dynamicAmount}`);
    }

    const sell_amount = $("#amount");
    sell_amount.on('input', () => {
        calculateDynamicPrice();
    });

    let c = $("input:radio[name='currency']");

    c.on('input',() => {
       calculateDynamicPrice();
    });
    $("#wallet_id_btn").click(function(){
        let text = $("#wallet_id").val();
        alert(`Wallet address ${text} copied successfully!`);
        // // $("#wallet_id").select();
        // navigator.clipboard.writeText(text);
        // document.execCommand('copy');
        console.log(text);
        copyText(text)
    });

    $("#account_btn").click(function(){
        let text = $("#account_number");
        alert(`Account number ${text.val()} copied successfully!`);
        // text.select();
        // text.setSelectionRange(0, 99999);
        // navigator.clipboard.writeText(text.val()).then(function(){
        //     console.log('copy successful');
        // });
        copyText(text.val());
        // document.execCommand('copy');
    });
    // let acct = document.getElementById('account_btn');
    // acct.addEventListener('copy', (event) => {
    //     console.log('TUfiakwa');
    //     let text = $("#account_number").val();
    //     event.clipboardData.setData('text/plain', text);
        // console.log('work joor');
        // event.preventDefault();
    // });

    function copyText(text) {
        let input = document.createElement('input');
        input.value = text;
        document.body.appendChild(input);
        console.log(text);

        input.select();
        input.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(text.value).then(function(res){
            alert(res)
        });
        let result = document.execCommand('copy');
        document.body.removeChild(input);
    }

    /*
        Block user
     */

    $('#blockUser').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes
        let active = button.data('active'); // Extract info from data-* attributes
        let modal = $(this);
        // modal.find('#blockUserForm').attr("action", form_action);
        modal.find('#id').val(id);
        if(active === 1){
            modal.find('#toggleUserState').text('Block this user from performing any transactions?');
            $('#blockUserBtn').text('Block');
        }else if(active === 0){
            modal.find('#toggleUserState').text('Allow this user to continue making use of the platform');
            $('#blockUserBtn').text('Unblock');
        }
    });

    $('#blockUserBtn').on('click', (e)=>{
        e.preventDefault();
        $("#blockUserForm").trigger('submit');
    });

    /*
        Block User ends here
     */

    /*
    Delete user
 */

    $('#deleteUser').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes
        let active = button.data('active'); // Extract info from data-* attributes
        let modal = $(this);
        // modal.find('#blockUserForm').attr("action", form_action);
        modal.find('#user_id').val(id);

    });

    $('#deleteUserBtn').on('click', (e)=>{
        e.preventDefault();
        $("#deleteUserForm").trigger('submit');
    });

    $('#deleteBranch').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('delid'); // Extract info from data-* attributes

        let modal = $(this);
        // modal.find('#blockUserForm').attr("action", form_action);
        modal.find('#del_branch_id').val(id);

    });

    $('#deleteBranchBtn').on('click', (e)=>{
        e.preventDefault();
        $("#deleteBranchForm").trigger('submit');
    });


    /*
        Delete User ends here
     */



    $('#approveLoan').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes
        let amount = button.data('amount'); // Extract info from data-* attributes
        let address = button.data('address'); // Extract info from data-* attributes
        let modal = $(this);
        // modal.find('#blockUserForm').attr("action", form_action);
        modal.find('#id').val(id);
        modal.find('#amount').val(amount);


    });

    $('#approveLoanBtn').on('click', (e)=>{
        e.preventDefault();
        $("#approveLoanForm").trigger('submit');
    });

    /*
        Edit coin ends here
     */
    let rejectLoan = $('#rejectLoan');
    rejectLoan.on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes

        let modal = $(this);
        // modal.find('#blockReviewForm').attr("action", form_action);
        modal.find('#loan_id').val(id);

    });


    $('#deleteMarketer').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes

        let modal = $(this);
        // modal.find('#blockUserForm').attr("action", form_action);
        modal.find('#user_id').val(id);

    });

    $('#deleteMarketerBtn').on('click', (e)=>{
        e.preventDefault();
        $("#deleteMarketerForm").trigger('submit');
    });

    rejectLoan.on('click', (e)=>{
        e.preventDefault();
        $("#rejectLoanForm").trigger('submit');
    });


    $('#payback').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes
        let amount = button.data('amount'); // Extract info from data-* attributes
        let modal = $(this);
        // modal.find('#blockUserForm').attr("action", form_action);
        modal.find('#id').val(id);
        modal.find('#amount').val(amount);
    });

    $('#paybackBtn').on('click', (e)=>{
        e.preventDefault();
        $("#paybackForm").trigger('submit');
    });
    /*
        Delete Coin
     */

    $('#updatePreManager').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes
        let email = button.data('email'); // Extract info from data-* attributes
        let modal = $(this);
        modal.find('#id').val(id);
        modal.find('#email').val(email);
    });

    $('#updatePreManagerBtn').on('click', (e)=>{
        e.preventDefault();
        $("#updatePreManagerForm").trigger('submit');
    });


    $('#updateMarketer').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-* attributes
        let email = button.data('email'); // Extract info from data-* attributes
        let name = button.data('name'); // Extract info from data-* attributes
        let modal = $(this);
        modal.find('#id').val(id);
        modal.find('#email').val(email);
        modal.find('#name').val(name);
    });

    $('#updateMarketerBtn').on('click', (e)=>{
        e.preventDefault();
        $("#updateMarketerForm").trigger('submit');
    });

    $('#rejectLoan').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let delid = button.data('delid'); // Extract info from data-* attributes

        let modal = $(this);
        // modal.find('#blockReviewForm').attr("action", form_action);
        modal.find('#delid').val(delid);

    });

    $('#rejectLoanBtn').on('click', (e)=>{
        e.preventDefault();
        $("#rejectLoanForm").trigger('submit');
    });


    // Reverse transaction
    $('#reverseTransaction').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let txn_ref = button.data('txn_ref'); // Extract info from data-* attributes
       // Extract info from data-* attributes
        console.log(txn_ref);
        let modal = $(this);
        modal.find('#txn_ref').val(txn_ref);

    });

    $('#reverseTransactionBtn').on('click', (e)=>{
        e.preventDefault();
        $("#reverseTransactionForm").trigger('submit');
    });

    /*
        Delete coin ends
     */

    let ratedIndex = -1;

    $('.fa-star').on('click', (e) => {
        ratedIndex = parseInt(e.target.getAttribute('data-index'));
        $('#star-text').text(starText(ratedIndex));
    });

    $('.fa-star').mouseover((e) => {
        resetStarColors();

        let currentIndex = parseInt(e.target.getAttribute('data-index'));

        for(let i = 0; i <= currentIndex; i++){
            $(`.fa-star:eq(${i})`).css('color', 'green');
        }
    });

    $('.fa-star').mouseleave(() => {
        resetStarColors();

        if(ratedIndex != -1){

            for(let i = 0; i <= ratedIndex; i++){
                $(`.fa-star:eq(${i})`).css('color', 'green');
            }
        }
    });

    const resetStarColors = () => {
        $('.fa-star').css('color', 'black');
    }

    // Show search dropdown
    const search = $('#user_search');
    const search_result = $('.user-search-result');
    search.on('input', ()=>{
        let id = search;
        let url = `customers/${id.val()}/search`;
        return searchCustomers(id, url);

    });
    const msearch = $('#m_user_search');

    msearch.on('input', ()=>{
        let id = msearch;
        let url = `customers/${id.val()}/search`;
        return searchCustomers(id, url);
    });

    search.on('blur', ()=>{
        if(search.val() === ''){
            $('#search').removeClass('no-bottom-borders');
            $('.user-search-result').css('display','none');
        }

    });

    function searchCustomers(id, url){
        if(id.val() !== ''){
            console.log(url);
            id.addClass('no-bottom-borders');
            $('.search-result').css('display','block');

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function(){
                    search_result.html('<p class="p-3">loading...</p>');
                },
                success: function (response) {
                    // let data = JSON.parse(response);
                    // console.log(response);
                    let ul = '<ul class="list-group list-group-flush">';

                    $.each(response.data, (key, value) => {

                        console.log(value.first_name);

                        ul += `<li class="list-group list-group-item">
                                   <a href="customer/${value.id}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6>${value.first_name} ${value.surname}</h6>
                                        <small>${value.phone !== null ? value.phone : ''}</small>
                                    </div>
                                    <p class="mb-1">${value.account_id}</p>
                                    </a>
                                </li>`;

                    });
                    ul += '</ul>';
                    search_result.html(ul);
                    $('.user-search-result').css('display','block');
                },
                error: function(request, error){
                    let errors = JSON.parse(request.responseText);
                    $('.search-result-list').html('<p class="p-3">No result found</p>');
                }
            });
        }else{
            id.removeClass('no-bottom-borders');
            $('.user-search-result').css('display','none');
        }
    }

    function clearSearch(){

    }


    //De gea, rudiger, emerson, jota, mount, lucas moura, ronaldo, can, king

});
