jQuery("body").on("click", '#vw-book-store-welcome-notice .notice-dismiss', function (event) {
    event.preventDefault();

    console.log("close clicked");

    jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      data: {
          action: 'vw_book_store_dismissed_notice',
      },
      success: function () {
          // Remove the notice on success
          $('.notice[data-notice="example"]').remove();
      }
    });
  }
)