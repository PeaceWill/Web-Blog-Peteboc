function setSidebarHeight() {
    var previewHeight = document.querySelector('.right-wrapper').clientHeight;
    var sidebar = document.querySelector('.sidebar');
    sidebar.style.height = `${previewHeight}px`;
}