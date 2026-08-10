
(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Sidebar toggle
   */

  // if (select('.toggle-sidebar-btn')) {
  //   on('click', '.toggle-sidebar-btn', function(e) {
  //     select('body').classList.toggle('toggle-sidebar')
  //   })
  // }

  if (select('.toggle-sidebar-btn')) {

    on('click', '.toggle-sidebar-btn', function(e) {

        const sidebarNav = document.querySelector('#sidebar-nav');
        const sidebar = document.querySelector('.sidebar');
        const main = document.querySelector('#main');
        const toggleIcon = document.querySelector('.toggle-sidebar-btn');

        const firstSpan = sidebarNav.querySelector('.nav-link span');
        const isHidden = firstSpan.classList.contains('d-none');

        const isRTL = document.documentElement.getAttribute('dir') === 'rtl';

        // Title toggle
        sidebarNav.querySelectorAll('.nav-link span').forEach(function(span) {
            span.classList.toggle('d-none');
        });

        if (isHidden) {
            // Sidebar OPEN
            sidebar.style.width = '300px';
            // Icon LEFT
            toggleIcon.classList.remove('bi-chevron-right');
            toggleIcon.classList.add('bi-chevron-left');

            if (main) {
                if (isRTL) {
                    main.style.marginRight = '300px';
                    main.style.marginLeft = '0';
                } else {
                    main.style.marginLeft = '300px';
                    main.style.marginRight = '0';
                }
            }

        } else {

            // Sidebar CLOSE
            sidebar.style.width = '90px';
            // Icon RIGHT
            toggleIcon.classList.remove('bi-chevron-left');
            toggleIcon.classList.add('bi-chevron-right');
            if (main) {
                if (isRTL) {
                    main.style.marginRight = '100px';
                    main.style.marginLeft = '0';
                } else {
                    main.style.marginLeft = '100px';
                    main.style.marginRight = '0';
                }
            }
        }

    });

}



  /**
   * Search bar toggle
   */
  if (select('.search-bar-toggle')) {
    on('click', '.search-bar-toggle', function(e) {
      select('.search-bar').classList.toggle('search-bar-show')
    })
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Initiate tooltips
   */
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  
  
  /**
   * Initiate Datatables
   */
  $('.datatable').DataTable({
    paging: true,
    searching: true,
    info: true,
    ordering: false, 
    lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "All"]],
    responsive: true,
    
  });


 /**
   * Phone Number
   */





})();

