function setSidebarHeight() {
    var previewHeight = document.querySelector('body').clientHeight;
    var sidebar = document.querySelector('.sidebar');
    sidebar.style.height = `${previewHeight}px`;
}