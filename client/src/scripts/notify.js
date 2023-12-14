import Notiflix from 'notiflix';

const notify = Notiflix;
notify.Loading.init({
    messageMaxLength: 60,
    fontFamily: 'Lexend',
    svgColor: '#d4d4d4',
    svgSize: '200px',
    zindex:999999999
})
notify.Notify.init({
    width: '30rem',
    position: 'right-top',
    distance: '20px',
    opacity: 1,
    borderRadius: '1rem',
    rtl: false,
    timeout: 4000,
    messageMaxLength: 110,
    backOverlay: false,
    backOverlayColor: 'rgba(0,0,0,0.5)',
    plainText: true,
    showOnlyTheLastOne: false,
    clickToClose: false,
    pauseOnHover: true,
    ID: 'NotiflixNotify',
    className: 'notiflix-notify',
    zindex: 4001,
    fontFamily: 'Lexend',
    fontSize: '1.2em',
    cssAnimation: true,
    cssAnimationDuration: 400,
    cssAnimationStyle: 'fade',
    closeButton: false,
    useIcon: true,
    useFontAwesome: false,
    fontAwesomeIconStyle: 'basic',
    fontAwesomeIconSize: '34px',
    clickToClose: true,
    success: {

        textColor: '#fff',
        childClassName: 'notiflix-notify-success bg-white',
        notiflixIconColor: 'rgba(255,255,255,1)',
        fontAwesomeClassName: 'fas fa-check-circle',
        fontAwesomeIconColor: 'rgba(255,255,255,1)',
        backOverlayColor: 'rgba(255,255,255,1)',
    },
    failure: {
        background: '#ff5549',
        textColor: '#fff',
        childClassName: 'notiflix-notify-failure',
        notiflixIconColor: 'rgba(255,255,255,1)',
        fontAwesomeIconColor: 'rgba(255,255,255,1)',
        fontAwesomeClassName: 'fas fa-times-circle',
        fontAwesomeIconColor: 'rgba(0,0,0,0.2)',
        backOverlayColor: 'rgba(255,85,73,0.2)',
    },
    warning: {
        background: '#eebf31',
        textColor: '#fff',
        childClassName: 'notiflix-notify-warning',
        notiflixIconColor: 'rgba(0,0,0,0.2)',
        fontAwesomeClassName: 'fas fa-exclamation-circle',
        fontAwesomeIconColor: 'rgba(0,0,0,0.2)',
        backOverlayColor: 'rgba(238,191,49,0.2)',
    },
    info: {
        background: '#334155',
        textColor: '#fff',
        childClassName: 'notiflix-notify-info',
        notiflixIconColor: 'rgba(0,0,0,0.2)',
        fontAwesomeClassName: 'fas fa-info-circle',
        fontAwesomeIconColor: 'rgba(0,0,0,0.2)',
        backOverlayColor: 'rgba(38,192,211,0.2)',
    },
});
notify.Confirm.init({
    titleColor: '#334155',
    width: '30vw',
    messageMaxLength: 1923,
    titleFontSize: '1.5rem',
    messageFontSize: '1.2rem',
    buttonsFontSize: '1rem',
    titleMaxLength: 50,
    plainText: true,
    fontFamily: 'Lexend',
    okButtonBackground: '#64748b',
});
notify.Report.init({
    titleFontSize: '1.3rem',
    messageFontSize: '1.2rem',
    buttonsFontSize: '1rem',
    plainText: false,
    fontFamily: 'Lexend',
    width: '30vw',
});

export default notify;