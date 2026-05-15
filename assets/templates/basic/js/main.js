"use strict";
(function ($) {
  /* ==================== Ready Function Start ========================== */
  $(document).ready(function () {
    /* ==================== Header Navbar Collapse JS Start ===================== */
    function hideNavbarCollapse() {
      new bootstrap.Collapse($(".navbar-collapse")[0]).hide();
      $(".navbar-collapse").trigger("hide.bs.collapse");
    }

    $(".navbar-collapse").on({
      "show.bs.collapse": function () {
        $("body").addClass("scroll-hide");
        $(".body-overlay").addClass("show").on("click", hideNavbarCollapse);
      },
      "hide.bs.collapse": function () {
        $("body").removeClass("scroll-hide");
        $(".body-overlay")
          .removeClass("show")
          .unbind("click", hideNavbarCollapse);
      },
    });
    /* ==================== Header Navbar Collapse JS End ======================= */

    /* ==================== Offcanvas Sidebar JS Start ======================== */
    $('[data-toggle="offcanvas-sidebar"]').each(function (index, toggler) {
      let id = $(toggler).data("target");
      let sidebar = $(id);
      let sidebarClose = sidebar.find(".btn--close");
      let sidebarOverlay = $(".sidebar-overlay");

      let hideSidebar = function () {
        sidebar.removeClass("show");
        sidebarOverlay.removeClass("show");
        $(toggler).removeClass("active");
        $("body").removeClass("scroll-hide");
        $(document).unbind("keydown", EscSidbear);
      };

      let EscSidbear = function (e) {
        if (e.keyCode === 27) {
          hideSidebar();
        }
      };

      let showSidebar = function () {
        $(toggler).addClass("active");
        sidebar.addClass("show");
        sidebarOverlay.addClass("show");
        $("body").addClass("scroll-hide");
        $(document).on("keydown", EscSidbear);
      };

      $(toggler).on("click", showSidebar);
      $(sidebarOverlay).on("click", hideSidebar);
      $(sidebarClose).on("click", hideSidebar);
    });
    /* ==================== Offcanvas Sidebar JS End ========================== */

    /* ==================== Overflow Content JS Start ========================= */
    $('[data-toggle="overflow-content"]').each((index, element) => {
      let content = $(element);
      let button = $(content.data("target"));

      if (content[0].scrollHeight > content[0].clientHeight) {
        button.addClass("show");
      }

      button.on("click", function () {
        content.toggleClass("show");

        if (content.hasClass("show")) {
          button.find("span").text("See less");
          button.find("i").removeClass("fa-angle-up").addClass("fa-angle-down");
        } else {
          button.find("span").text("See more");
          button.find("i").removeClass("fa-angle-down").addClass("fa-angle-up");
        }
      });
    });
    /* ==================== Overflow Content JS End =========================== */

    /* ==================== Initialize overlayscrollbars JS Start ============== */
    let { OverlayScrollbars } = OverlayScrollbarsGlobal;

    $(".offcanvas-sidebar").each((index, element) => {
      let sidebar = $(element);
      let sidebarBody = sidebar.find(".offcanvas-sidebar__body");

      if (sidebarBody.length) {
        OverlayScrollbars(sidebarBody[0], {});
      }
    });
    /* ==================== Initialize overlayscrollbars JS End ================ */

    /* ==================== Dynamically Add BG Image JS Start ====================== */
    $(".bg-img").css("background-image", function () {
      let bg = `url(${$(this).data("background-image")})`;
      return bg;
    });
    /* ==================== Dynamically Add BG Image JS End ======================== */

    /* ==================== Add A Class In Select Input JS Start ============================== */
    $(".form-select.form--select").each(function (index, select) {
      $(select).on("change", function () {
        if ($(this).val()) {
          $(this).addClass("selected");
        } else {
          $(this).removeClass("selected");
        }
      });
    });
    /* ==================== Add A Class In Select Input JS End ================================ */

    /* ==================== Password Toggle JS Start ================================ */
    $(".input--group-password").each(function (index, inputGroup) {
      let inputGroupBtn = $(inputGroup).find(".input-group-btn");
      let formControl = $(inputGroup).find(".form-control.form--control");

      inputGroupBtn.on("click", function () {
        if (formControl.attr("type") === "password") {
          formControl.attr("type", "text");
          $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
        } else {
          formControl.attr("type", "password");
          $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
        }
      });
    });
    /* ==================== Password Toggle JS End ================================== */

    /* ==================== Gig Card Layout Toggle JS Start ========================= */
    let jssRow = $(".jss-row");
    let layoutToggleBtns = $(
      '.layout-toggle-btn:not([data-toggle="offcanvas-sidebar"])'
    );

    layoutToggleBtns.on("click", function () {
      // Remove existing active class
      layoutToggleBtns.each((index, btn) => {
        if ($(btn).hasClass("active")) {
          $(btn).removeClass("active");
        }
      });

      // Add active class to the clicked button
      if (!$(this).hasClass("active")) {
        $(this).addClass("active");
      }

      // Enable Grid Layout
      if ($(this).hasClass("grid-layout")) {
        jssRow.removeClass("row-list-layout");
      }

      // Enable List Layout
      if ($(this).hasClass("list-layout")) {
        jssRow.addClass("row-list-layout");
      }
    });
    /* ==================== Gig Card Layout Toggle JS End =========================== */
    /* ==================== Page Wraper Overlay Append JS Start ========================= */
    let pageWrapper = $(".page-wrapper");

    if (!pageWrapper.find(" > .dashboard").length) {
      pageWrapper.prepend(`
        <div class="page-wrapper__shape one"></div>  
        <div class="page-wrapper__shape two"></div>  
      `);
    }
    /* ==================== Page Wraper Overlay Append JS End =========================== */
  });
  /* ==================== Ready Function End ============================ */

  /* ==================== Header Fixed JS Start ========================= */
  $(window).on("scroll", function (e) {
    if ($(window).scrollTop() >= 300) {
      $(".header").addClass("fixed-header");
    } else {
      $(".header").removeClass("fixed-header");
    }
  });
  /* ==================== Header Fixed JS End ============================= */

  /* ==================== Scroll To Top Button JS Start =========================== */
  let scrollTopBtn = $(".scroll-top");

  scrollTopBtn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });

  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 300) {
      scrollTopBtn.addClass("show");
    } else {
      scrollTopBtn.removeClass("show");
    }
  });
  /* ==================== Scroll To Top Button JS End ============================= */

  /* ==================== Preloader JS Start ====================================== */
  $(window).on("load", () => $(".preloader").fadeOut());
  /* ==================== Preloader JS End ======================================== */

  /* ==================== Layout Select Start ======================================== */
  function updateView() {
    const productViewType =
      localStorage.getItem("product_view_type") || "grid-view";
    $(".jss-row")
      .removeClass("row-list-layout")
      .addClass(productViewType === "list-view" ? "row-list-layout" : "");
    $(".layout-toggle-btns button").removeClass("active");

    if (productViewType === "grid-view") {
      $(".grid-layout").addClass("active");
    } else {
      $(".list-layout").addClass("active");
    }
  }

  function setViewTypeAndApply(viewType) {
    localStorage.setItem("product_view_type", viewType);
    updateView();
  }

  updateView();

  function transitionRemove() {
    // Remove transitions temporarily
    $(".jss--card-service *").css({
      transition: "unset",
    });

    // Restore transitions after 100ms
    setTimeout(() => {
      $(".jss--card-service *").css({
        transition:
          "transform 0.3s ease-in-out, -webkit-transform 0.3s ease-in-out",
      });
    }, 50);
  }

  $(".grid-layout").on("click", function () {
    setViewTypeAndApply("grid-view");
    transitionRemove();
  });

  $(".list-layout").on("click", function () {
    setViewTypeAndApply("list-view");
    transitionRemove();
  });
  /* ==================== Layout Select End ======================================== */

  /* ==================== Make Favorite Start ======================================== */
  $(document).on("click", ".make-favorite", function () {
    var auth = $(this).data("auth");
    if (!auth) {
      $("#loginModal").modal("show");
      return;
    }

    var productId = $(this).data("id");
    var type = $(this).data("type");
    var $this = $(this);
    $.ajax({
      type: "get",
      url: $(this).data("action"),
      data: {
        product_id: productId,
        type: type,
      },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          notify("success", response.success);
          $($this)
            .parent()
            .find(".favorite-count")
            .text(response.favoriteCount);
          if (response.added) {
            $($this).addClass("active");
          } else {
            $($this).removeClass("active");
          }
        } else {
          notify("error", response.error);
        }
      },
    });
  });
  /* ==================== Make Favorite End ======================================== */
})(jQuery);
