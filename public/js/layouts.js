document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    
    function adjustFooterPosition() {
        const contentHeight = document.querySelector('#content').offsetHeight;
        const windowHeight = window.innerHeight;
        const headerHeight = document.querySelector('.topbar').offsetHeight;
        // const footerHeight = document.querySelector('footer.sticky-footer').offsetHeight;
        
        // if (contentHeight < (windowHeight - headerHeight - footerHeight)) {
        //     document.querySelector('.min-content-height').style.minHeight = 
        //         (windowHeight - headerHeight - footerHeight - 40) + 'px';
        // }
    }
    
    function ensureSidebarHeight() {
        if (!sidebar) return;
        
        const lastItem = sidebar.querySelector('.sidebar-heading:last-of-type, .nav-item:last-of-type');
        if (!lastItem) return;
        
        const lastItemBottom = lastItem.offsetTop + lastItem.offsetHeight;
        const windowHeight = window.innerHeight;
        const minSidebarHeight = Math.max(lastItemBottom + 100, windowHeight);
        
        sidebar.style.minHeight = `${minSidebarHeight}px`;
    }
    
    adjustFooterPosition();
    ensureSidebarHeight();
    
    window.addEventListener('resize', adjustFooterPosition);
    window.addEventListener('resize', ensureSidebarHeight);
    window.addEventListener('load', ensureSidebarHeight);
    
    const collapseTriggers = document.querySelectorAll('[data-toggle="collapse"]');
    collapseTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            setTimeout(ensureSidebarHeight, 350);
        });
    });
    
    if (sidebar) {
        sidebar.addEventListener('scroll', function(e) {
            const scrollTop = this.scrollTop;
            const scrollHeight = this.scrollHeight;
            const offsetHeight = this.offsetHeight;
            
            if (scrollTop === 0) {
                this.scrollTop = 1;
            } else if (scrollTop + offsetHeight >= scrollHeight) {
                this.scrollTop = scrollTop - 1;
            }
        });
    }
});