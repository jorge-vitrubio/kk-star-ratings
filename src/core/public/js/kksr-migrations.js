/**
 * kk Star Ratings
 * @see https://github.com/kamalkhan/kk-star-ratings
 */

"use strict";

jQuery(document).ready(function ($) {
  function ajax(successCallback, errorCallback) {
    $.ajax({
      type: "POST",
      url: kksr_migrations.endpoint,
      data: {
        nonce: kksr_migrations.nonce,
        action: kksr_migrations.action,
      },
      error: errorCallback,
      success: successCallback,
    });
  }

  function migrate() {
    ajax(
      function (response, status, xhr) {
        if (response) {
          if (response.status == "pending") {
            migrate();
          } else if (response.status == "busy") {
            setTimeout(migrate, 5000);
          }
        }
      },
      function (xhr, status, err) {
        if (xhr.responseJSON && xhr.responseJSON.error) {
          console.error(xhr.responseJSON.error);
        }
      }
    );
  }

  migrate();
});
