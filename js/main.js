(function () {
  var docElem = document.documentElement,
    didScroll = false,
    menu = document.getElementById('main-menu'),
    mh = menu.clientHeight,
    changeHeaderOn = mh

  docElem.style.setProperty('--mh', (mh + 10) + 'px')

  function scrollPage () {
    var sy = scrollY()
    if (sy >= changeHeaderOn) {
      document.getElementById('main-menu')
        .classList
        .add('fixed')
    } else {
      document.getElementById('main-menu')
        .classList
        .remove('fixed')
    }
    didScroll = false
  }

  function scrollY () {
    return window.pageYOffset || docElem.scrollTop
  }

  window.addEventListener('scroll', function (event) {
    if (!didScroll) {
      didScroll = true
      scrollPage()
    }
  }, false)

  if (!('scrollBehavior' in docElem.style)) {
    var links = document.querySelectorAll('.article-links');
    [].forEach.call(links, function (el) {
      el.addEventListener('click', function () {
        setTimeout(scrollBack, 10)
      },
      false)
    })
  }

  function scrollBack () {
    var menu = document.getElementById('main-menu'), mh = menu.clientHeight,
      scrl = -mh - 15
    window.scrollBy(0, scrl)
  }

  window.addEventListener('wpcf7submit', (e) => {
    const tuitionField = document.querySelector('.wpcf7-form-control-wrap[data-name="tuition-amount"] input')
    const tuitionAmount = tuitionField.value
    const tuitionMessage = document.createElement('p')
    tuitionMessage.innerHTML = `Paying tuition amount of $${tuitionAmount}.`
    tuitionField.setAttribute('disabled', true)
    tuitionField.insertAdjacentElement('afterend', tuitionMessage)
  })
})()
