jQuery(document).ready(function ($) {
  console.log(window, 998, __params, $)
  $.ajax({
    url: __params.ajax_url,
    method: 'POST',
    dataType: 'json',
    data: {
      action: 'test_me',
      nonce: __params.test_me_nonce,
      // nonce: __params.ajaxNonce,
      input: '哈哈哈',
    }
  }).done(function (e) {
    console.log(e, 10);
  }).fail(function (err) {
    console.log(err, 20);
  })
  console.log(React, ReactDOM, 123);
//  const root = ReactDOM.createRoot(document.getElementById('root'));
//  root.render(React.createElement('h1', null, 'Hello, React 19333!'));

  
});