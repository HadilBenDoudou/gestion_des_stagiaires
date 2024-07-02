document.addEventListener('DOMContentLoaded', function () {
    const showOldPwdIcon = document.querySelector('.show-old-pwd');
    const oldPwdInput = document.querySelector('.oldpwd');

    const showNewPwdIcon = document.querySelector('.show-new-pwd');
    const newPwdInput = document.querySelector('.newpwd');

    showOldPwdIcon.addEventListener('click', togglePwdVisibility.bind(null, oldPwdInput));
    showNewPwdIcon.addEventListener('click', togglePwdVisibility.bind(null, newPwdInput));

    function togglePwdVisibility(pwdInput) {
        const type = pwdInput.type === 'password' ? 'text' : 'password';
        pwdInput.type = type;
    }
});