(function($) {
  'use strict';
  
  function capitalizeFirstLetter(string)
  {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
  
  var $sidebar = $('.control-sidebar');
  var $container = $('<div />', {
    class: 'p-3 control-sidebar-content',
  });
  
  $sidebar.append($container);
  
  // Checkboxes
  
  $container.append('<h5>Interface Settings</h5><hr class="mb-2"/>');
  
  var $dark_mode_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('dark-mode'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('dark-mode');
      $.ajax({
        url: 'theme.php', type: 'post', data: {modeData: 'dark-mode'},
      });
    }
    else {
      $('body').removeClass('dark-mode');
      $.ajax({
        url: 'theme.php', type: 'post', data: {modeData: ''},
      });
    }
  });
  var $dark_mode_container = $('<div />', {class: 'mb-4'}).
      append($dark_mode_checkbox).
      append('<span>Dark Mode</span>');
  $container.append($dark_mode_container);
  
  $container.append('<h6>Header Options</h6>');
  
  var $header_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-navbar-fixed'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-navbar-fixed');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {headerFixedData: 'layout-navbar-fixed'},
      });
    }
    else {
      $('body').removeClass('layout-navbar-fixed');
      $.ajax({
        url: 'theme.php', type: 'post', data: {headerFixedData: ''},
      });
    }
  });
  var $header_fixed_container = $('<div />', {class: 'mb-1'}).
      append($header_fixed_checkbox).
      append('<span>Fixed</span>');
  $container.append($header_fixed_container);
  
  var $dropdown_legacy_offset_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('dropdown-legacy'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('dropdown-legacy');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {headerLegacyData: 'dropdown-legacy'},
      });
    }
    else {
      $('.main-header').removeClass('dropdown-legacy');
      $.ajax({
        url: 'theme.php', type: 'post', data: {headerLegacyData: ''},
      });
    }
  });
  var $dropdown_legacy_offset_container = $('<div />', {class: 'mb-1'}).
      append($dropdown_legacy_offset_checkbox).
      append('<span>Dropdown Legacy Offset</span>');
  $container.append($dropdown_legacy_offset_container);
  
  var $no_border_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('border-bottom-0'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('border-bottom-0');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {headerBorderData: 'border-bottom-0'},
      });
    }
    else {
      $('.main-header').removeClass('border-bottom-0');
      $.ajax({
        url: 'theme.php', type: 'post', data: {headerBorderData: ''},
      });
    }
  });
  var $no_border_container = $('<div />', {class: 'mb-4'}).
      append($no_border_checkbox).
      append('<span>No border</span>');
  $container.append($no_border_container);
  
  $container.append('<h6>Sidebar Options</h6>');
  
  var $sidebar_collapsed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('sidebar-collapse'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-collapse');
      $(window).trigger('resize');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {sidebarCollapseData: 'sidebar-collapse'},
      });
    }
    else {
      $('body').removeClass('sidebar-collapse');
      $(window).trigger('resize');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarCollapseData: ''},
      });
    }
  });
  var $sidebar_collapsed_container = $('<div />', {class: 'mb-1'}).
      append($sidebar_collapsed_checkbox).
      append('<span>Collapsed</span>');
  $container.append($sidebar_collapsed_container);
  
  $(document).
      on('collapsed.lte.pushmenu', '[data-widget="pushmenu"]', function() {
        $sidebar_collapsed_checkbox.prop('checked', true);
      });
  $(document).on('shown.lte.pushmenu', '[data-widget="pushmenu"]', function() {
    $sidebar_collapsed_checkbox.prop('checked', false);
  });
  
  var $sidebar_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-fixed'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-fixed');
      $(window).trigger('resize');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {sidebarFixedData: 'layout-fixed'},
      });
    }
    else {
      $('body').removeClass('layout-fixed');
      $(window).trigger('resize');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarFixedData: ''},
      });
    }
  });
  var $sidebar_fixed_container = $('<div />', {class: 'mb-1'}).
      append($sidebar_fixed_checkbox).
      append('<span>Fixed</span>');
  $container.append($sidebar_fixed_container);
  
  var $sidebar_mini_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('sidebar-mini'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-mini');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniData: 'sidebar-mini'},
      });
    }
    else {
      $('body').removeClass('sidebar-mini');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniData: ''},
      });
    }
  });
  var $sidebar_mini_container = $('<div />', {class: 'mb-1'}).
      append($sidebar_mini_checkbox).
      append('<span>Sidebar Mini</span>');
  $container.append($sidebar_mini_container);
  
  var $sidebar_mini_md_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('sidebar-mini-md'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-mini-md');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {sidebarMiniMDData: 'sidebar-mini-md'},
      });
    }
    else {
      $('body').removeClass('sidebar-mini-md');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniMDData: ''},
      });
    }
  });
  var $sidebar_mini_md_container = $('<div />', {class: 'mb-1'}).
      append($sidebar_mini_md_checkbox).
      append('<span>Sidebar Mini MD</span>');
  $container.append($sidebar_mini_md_container);
  
  var $sidebar_mini_xs_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('sidebar-mini-xs'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-mini-xs');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {sidebarMiniXSData: 'sidebar-mini-xs'},
      });
    }
    else {
      $('body').removeClass('sidebar-mini-xs');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniXSData: ''},
      });
    }
  });
  var $sidebar_mini_xs_container = $('<div />', {class: 'mb-1'}).
      append($sidebar_mini_xs_checkbox).
      append('<span>Sidebar Mini XS</span>');
  $container.append($sidebar_mini_xs_container);
  
  var $flat_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-flat'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-flat');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarFlatData: 'nav-flat'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-flat');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarFlatData: ''},
      });
    }
  });
  var $flat_sidebar_container = $('<div />', {class: 'mb-1'}).
      append($flat_sidebar_checkbox).
      append('<span>Nav Flat Style</span>');
  $container.append($flat_sidebar_container);
  
  var $legacy_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-legacy'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-legacy');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarLegacyData: 'nav-legacy'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-legacy');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarLegacyData: ''},
      });
    }
  });
  var $legacy_sidebar_container = $('<div />', {class: 'mb-1'}).
      append($legacy_sidebar_checkbox).
      append('<span>Nav Legacy Style</span>');
  $container.append($legacy_sidebar_container);
  
  var $compact_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-compact'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-compact');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {sidebarCompactData: 'nav-compact'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-compact');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarCompactData: ''},
      });
    }
  });
  var $compact_sidebar_container = $('<div />', {class: 'mb-1'}).
      append($compact_sidebar_checkbox).
      append('<span>Nav Compact</span>');
  $container.append($compact_sidebar_container);
  
  var $child_indent_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-child-indent'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-child-indent');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {sidebarIndentChildData: 'nav-child-indent'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-child-indent');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarIndentChildData: ''},
      });
    }
  });
  var $child_indent_sidebar_container = $('<div />', {class: 'mb-1'}).
      append($child_indent_sidebar_checkbox).
      append('<span>Nav Child Indent</span>');
  $container.append($child_indent_sidebar_container);
  
  var $child_hide_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-collapse-hide-child'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-collapse-hide-child');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {sidebarHideOnCollapseChildData: 'nav-collapse-hide-child'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-collapse-hide-child');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {sidebarHideOnCollapseChildData: ''},
      });
    }
  });
  var $child_hide_sidebar_container = $('<div />', {class: 'mb-1'}).
      append($child_hide_sidebar_checkbox).
      append('<span>Nav Child Hide on Collapse</span>');
  $container.append($child_hide_sidebar_container);
  
  var $no_expand_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-sidebar').hasClass('sidebar-no-expand'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-sidebar').addClass('sidebar-no-expand');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {sidebarDisableHoverData: 'sidebar-no-expand'},
      });
    }
    else {
      $('.main-sidebar').removeClass('sidebar-no-expand');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarDisableHoverData: ''},
      });
    }
  });
  var $no_expand_sidebar_container = $('<div />', {class: 'mb-4'}).
      append($no_expand_sidebar_checkbox).
      append('<span>Disable Hover/Focus Auto-Expand</span>');
  $container.append($no_expand_sidebar_container);
  
  $container.append('<h6>Footer Options</h6>');
  
  var $footer_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-footer-fixed'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-footer-fixed');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {fixedFooterData: 'layout-footer-fixed'},
      });
    }
    else {
      $('body').removeClass('layout-footer-fixed');
      $.ajax({
        url: 'theme.php', type: 'post', data: {fixedFooterData: ''},
      });
    }
  });
  var $footer_fixed_container = $('<div />', {class: 'mb-4'}).
      append($footer_fixed_checkbox).
      append('<span>Fixed</span>');
  $container.append($footer_fixed_container);
  
  $container.append('<h6>Small Text Options</h6>');
  
  var $text_sm_body_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('text-sm'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallBodyTextData: 'text-sm'},
      });
    }
    else {
      $('body').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallBodyTextData: ''},
      });
    }
  });
  var $text_sm_body_container = $('<div />', {class: 'mb-1'}).
      append($text_sm_body_checkbox).
      append('<span>Body</span>');
  $container.append($text_sm_body_container);
  
  var $text_sm_header_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('text-sm'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallNavbarTextData: 'text-sm'},
      });
    }
    else {
      $('.main-header').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallNavbarTextData: ''},
      });
    }
  });
  var $text_sm_header_container = $('<div />', {class: 'mb-1'}).
      append($text_sm_header_checkbox).
      append('<span>Navbar</span>');
  $container.append($text_sm_header_container);
  
  var $text_sm_brand_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.brand-link').hasClass('text-sm'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.brand-link').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallBrandData: 'text-sm'},
      });
    }
    else {
      $('.brand-link').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallBrandData: ''},
      });
    }
  });
  var $text_sm_brand_container = $('<div />', {class: 'mb-1'}).
      append($text_sm_brand_checkbox).
      append('<span>Brand</span>');
  $container.append($text_sm_brand_container);
  
  var $text_sm_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('text-sm'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallSidebarTextData: 'text-sm'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallSidebarTextData: ''},
      });
    }
  });
  var $text_sm_sidebar_container = $('<div />', {class: 'mb-1'}).
      append($text_sm_sidebar_checkbox).
      append('<span>Sidebar Nav</span>');
  $container.append($text_sm_sidebar_container);
  
  var $text_sm_footer_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-footer').hasClass('text-sm'),
    class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-footer').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallFooterTextData: 'text-sm'},
      });
    }
    else {
      $('.main-footer').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallFooterTextData: ''},
      });
    }
  });
  var $text_sm_footer_container = $('<div />', {class: 'mb-4'}).
      append($text_sm_footer_checkbox).
      append('<span>Footer</span>');
  $container.append($text_sm_footer_container);
  
  // Color Arrays
  
  var navbar_dark_skins = [
    'navbar-primary',
    'navbar-secondary',
    'navbar-info',
    'navbar-success',
    'navbar-danger',
    'navbar-indigo',
    'navbar-purple',
    'navbar-pink',
    'navbar-navy',
    'navbar-lightblue',
    'navbar-teal',
    'navbar-cyan',
    'navbar-dark',
    'navbar-gray-dark',
    'navbar-gray',
  ];
  
  var navbar_light_skins = [
    'navbar-light', 'navbar-warning', 'navbar-white', 'navbar-orange',
  ];
  
  var sidebar_colors = [
    'bg-primary',
    'bg-warning',
    'bg-info',
    'bg-danger',
    'bg-success',
    'bg-indigo',
    'bg-lightblue',
    'bg-navy',
    'bg-purple',
    'bg-fuchsia',
    'bg-pink',
    'bg-maroon',
    'bg-orange',
    'bg-lime',
    'bg-teal',
    'bg-olive',
  ];
  
  var accent_colors = [
    'accent-primary',
    'accent-warning',
    'accent-info',
    'accent-danger',
    'accent-success',
    'accent-indigo',
    'accent-lightblue',
    'accent-navy',
    'accent-purple',
    'accent-fuchsia',
    'accent-pink',
    'accent-maroon',
    'accent-orange',
    'accent-lime',
    'accent-teal',
    'accent-olive',
  ];
  
  var sidebar_skins = [
    'sidebar-dark-primary',
    'sidebar-dark-warning',
    'sidebar-dark-info',
    'sidebar-dark-danger',
    'sidebar-dark-success',
    'sidebar-dark-indigo',
    'sidebar-dark-lightblue',
    'sidebar-dark-navy',
    'sidebar-dark-purple',
    'sidebar-dark-fuchsia',
    'sidebar-dark-pink',
    'sidebar-dark-maroon',
    'sidebar-dark-orange',
    'sidebar-dark-lime',
    'sidebar-dark-teal',
    'sidebar-dark-olive',
    'sidebar-light-primary',
    'sidebar-light-warning',
    'sidebar-light-info',
    'sidebar-light-danger',
    'sidebar-light-success',
    'sidebar-light-indigo',
    'sidebar-light-lightblue',
    'sidebar-light-navy',
    'sidebar-light-purple',
    'sidebar-light-fuchsia',
    'sidebar-light-pink',
    'sidebar-light-maroon',
    'sidebar-light-orange',
    'sidebar-light-lime',
    'sidebar-light-teal',
    'sidebar-light-olive',
  ];
  
  // Navbar Variants
  
  $container.append('<h6>Navbar Variants</h6>');
  
  var $navbar_variants = $('<div />', {
    'class': 'd-flex',
  });
  var navbar_all_colors = navbar_dark_skins.concat(navbar_light_skins);
  var $navbar_variants_colors = createSkinBlock(navbar_all_colors, function(e) {
    var color = $(this).data('color');
    var $main_header = $('.main-header');
    $main_header.removeClass('navbar-dark').removeClass('navbar-light');
    navbar_all_colors.map(function(color) {
      $main_header.removeClass(color);
    });
    
    if (navbar_dark_skins.indexOf(color) > -1) {
      $main_header.addClass('navbar-dark');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {themeData: 'navbar-dark ' + color},
      });
    }
    else {
      $main_header.addClass('navbar-light');
      $.ajax({
        url: 'theme.php',
        type: 'post',
        data: {themeData: 'navbar-light ' + color},
      });
    }
    
    $main_header.addClass(color);
  });
  
  $navbar_variants.append($navbar_variants_colors);
  
  $container.append($navbar_variants);
  
  // Sidebar Colors
  
  $container.append('<h6>Accent Color Variants</h6>');
  var $accent_variants = $('<div />', {
    'class': 'd-flex',
  });
  $container.append($accent_variants);
  $container.append(createSkinBlock(accent_colors, function() {
    var color = $(this).data('color');
    var accent_class = color;
    var $body = $('body');
    accent_colors.map(function(skin) {
      $body.removeClass(skin);
    });
    
    $body.addClass(accent_class);
    $.ajax({
      url: 'theme.php', type: 'post', data: {themeData: color},
    });
  }));
  
  $container.append('<h6>Dark Sidebar Variants</h6>');
  var $sidebar_variants_dark = $('<div />', {
    'class': 'd-flex',
  });
  $container.append($sidebar_variants_dark);
  $container.append(createSkinBlock(sidebar_colors, function() {
    var color = $(this).data('color');
    var sidebar_class = 'sidebar-dark-' + color.replace('bg-', '');
    var $sidebar = $('.main-sidebar');
    sidebar_skins.map(function(skin) {
      $sidebar.removeClass(skin);
    });
    
    $sidebar.addClass(sidebar_class);
    $.ajax({
      url: 'theme.php', type: 'post', data: {themeData: sidebar_class},
    });
  }));
  
  $container.append('<h6>Light Sidebar Variants</h6>');
  var $sidebar_variants_light = $('<div />', {
    'class': 'd-flex',
  });
  $container.append($sidebar_variants_light);
  $container.append(createSkinBlock(sidebar_colors, function() {
    var color = $(this).data('color');
    var sidebar_class = 'sidebar-light-' + color.replace('bg-', '');
    var $sidebar = $('.main-sidebar');
    sidebar_skins.map(function(skin) {
      $sidebar.removeClass(skin);
    });
    
    $sidebar.addClass(sidebar_class);
    $.ajax({
      url: 'theme.php', type: 'post', data: {themeData: sidebar_class},
    });
  }));
  
  var logo_skins = navbar_all_colors;
  $container.append('<h6>Brand Logo Variants</h6>');
  var $logo_variants = $('<div />', {
    'class': 'd-flex',
  });
  $container.append($logo_variants);
  var $clear_btn = $('<a />', {
    href: 'javascript:void(0)',
  }).text('clear').on('click', function() {
    var $logo = $('.brand-link');
    logo_skins.map(function(skin) {
      $logo.removeClass(skin);
    });
  });
  $container.append(createSkinBlock(logo_skins, function() {
    var color = $(this).data('color');
    var $logo = $('.brand-link');
    logo_skins.map(function(skin) {
      $logo.removeClass(skin);
    });
    $logo.addClass(color);
    $.ajax({
      url: 'theme.php', type: 'post', data: {themeData: 'logo ' + color},
    });
  }).append($clear_btn));
  
  function createSkinBlock(colors, callback)
  {
    var $block = $('<div />', {
      'class': 'd-flex flex-wrap mb-3',
    });
    
    colors.map(function(color) {
      var $color = $('<div />', {
        'class': (typeof color === 'object' ? color.join(' ') : color).replace(
            'navbar-', 'bg-').replace('accent-', 'bg-') + ' elevation-2',
      });
      
      $block.append($color);
      
      $color.data('color', color);
      
      $color.css({
        width: '40px',
        height: '20px',
        borderRadius: '25px',
        marginRight: 10,
        marginBottom: 10,
        opacity: 0.8,
        cursor: 'pointer',
      });
      
      $color.hover(function() {
        $(this).
            css({opacity: 1}).
            removeClass('elevation-2').
            addClass('elevation-4');
      }, function() {
        $(this).
            css({opacity: 0.8}).
            removeClass('elevation-4').
            addClass('elevation-2');
      });
      
      if (callback) {
        $color.on('click', callback);
      }
    });
    
    return $block;
  }
  
  $('.product-image-thumb').on('click', function() {
    const image_element = $(this).find('img');
    $('.product-image').prop('src', $(image_element).attr('src'));
    $('.product-image-thumb.active').removeClass('active');
    $(this).addClass('active');
  });
  
  $container.append('<br><br><br><br>');
  
  /***************************************************************************************************************
   * My Customizations
   */
  $(document).ready(function() {
    togglePasswordVisibility();
    toggleDarkMode();
    activateDataTable();
    activateEditor();
    updateOnlineOrderStatus();
  });
  
  //Activate Active menu Item
  /** add active class and stay opened when selected */
  var url = window.location;
  // for sidebar menu entirely but not cover treeview
  $('ul.nav-sidebar a').filter(function() {
    return this.href == url;
  }).addClass('active');
  // for treeview
  $('ul.nav-treeview a').
      filter(function() {
        return this.href == url;
      }).
      parentsUntil('.nav-sidebar > .nav-treeview').
      addClass('menu-is-opening menu-open').
      prev('a').
      addClass('active');
  
  function togglePasswordVisibility()
  {
    var eyeIcon = $('visibilityIcon');
  }
  
  function toggleDarkMode()
  {
    // Get the dark mode preference from localStorage (if set)
    const darkMode = localStorage.getItem('darkMode');
    
    // Set the dark mode class based on the user preference
    if (darkMode === 'enabled') {
      $('body').addClass('dark-mode');
    }
    
    // Toggle dark mode and change the icon on click
    $('#dark-mode-toggle').on('click', function() {
      if ($('body').hasClass('dark-mode')) {
        // Disable dark mode
        $('body').removeClass('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
        // Change the icon to moon
        $('#dark-mode-toggle i').
            removeClass('fas fa-sun').
            addClass('fas fa-moon');
      }
      else {
        // Enable dark mode
        $('body').addClass('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
        // Change the icon to sun
        $('#dark-mode-toggle i').
            removeClass('fas fa-moon').
            addClass('fas fa-sun');
      }
    });
  }
  
  // Initialize the datatables
  function activateDataTable()
  {
    if ($('.dataTable').length) {
      $('.dataTable').dataTable({
        /*dom: 'Bfrtip',
        buttons: [
          'excel'
        ],*/
        dom: 'Bfrtip', // Start for other button options
        buttons: [
          {
            extend: 'excelHtml5', text: 'Excel Current', exportOptions: {
              columns: ':visible', modifier: {
                page: 'current',
              },
            },
          }, {
            extend: 'excelHtml5', text: 'Excel ', exportOptions: {
              columns: ':visible',
            },
          }, {
            extend: 'csv', text: 'CSV', exportOptions: {
              columns: ':visible',
            },
          }, {
            extend: 'pdf', exportOptions: {
              columns: ':visible',
            },
          }, {
            extend: 'print', exportOptions: {
              columns: ':visible',
            },
          }, {
            extend: 'copyHtml5', text: 'Copy Current', exportOptions: {
              columns: ':visible', modifier: {
                page: 'current',
              },
            },
          }, {
            extend: 'copyHtml5', text: 'Copy', exportOptions: {
              columns: ':visible',
            },
          }, 'colvis',
        ], // End of other buttons options*/
        'bDestroy': true, initComplete: function() {
          this.api().columns().every(function() {
            var column = this;
            var select = $(
                '<select  class="browser-default select2 w-100 custom-select form-control-sm"><option value="" selected>Search</option></select>').
                appendTo($(column.footer()).empty()).
                appendTo($(column.footer()).empty()).
                on('change', function() {
                  var val = $.fn.dataTable.util.escapeRegex($(this).val());
                  
                  column.search(val ? '^' + val + '$' : '', true, false).draw();
                });
            
            column.data().unique().sort().each(function(d, j) {
              select.append('<option value="' + d + '">' + d + '</option>');
            });
          });
        },
      });
    }
  }
  
  // Initialize the combobox
  function activateSelect()
  {
    if ($('.select2').length) {
      $('.select2').select2({
        width: '100%',
      });
    }
  }
  
  // Add forn-control-sm to all form-controls
  function addSMControls()
  {
    $('.form-control').addClass('form-control-sm');
  }
  
  function activateEditor()
  {
    if ($('.editor').length) {
      $('.editor').summernote();
    }
  }
  
  // Initialize tooltips
  $('[data-toggle="tooltip"]').tooltip();
  
  function activateToolTips()
  {
    $('[data-toggle="tooltip"]').tooltip();
  }
  
  // Messages .messageCount on the menu
  
  /*****************************************************************************************
   * Dashboard
   *****************************************************************************************/
  // Function to create and initialize the real-time sales chart
  function createRealTimeChart()
  {
    const ctx = document.getElementById('realTimeSalesChart').getContext('2d');
    
    // Check if the dark mode class is applied to the body
    const isDarkMode = $('body').hasClass('dark-mode');
    
    // Define label color based on mode
    const labelColor = isDarkMode ? 'white' : 'black'; // Adjust the color as
                                                       // needed
    
    const salesChart = new Chart(ctx, {
      type: 'bar', data: {
        labels: [], // X-axis labels (timestamps)
        datasets: [
          {
            label: 'Revenue',
            data: [], // Sales data points
            fill: true,
            borderColor: 'rgb(20, 120, 255)',
            backgroundColor: 'rgba(20, 120, 255)',
            tension: 0.3,
            color: labelColor,
          }, {
            label: 'Costs',
            data: [], // Sales data points
            fill: true,
            borderColor: 'rgb(255,20,141)',
            backgroundColor: 'rgba(255, 20, 141)',
            tension: 0.3,
            color: labelColor,
          },
        ],
      }, options: {
        maintainAspectRatio: false, responsive: true, legends: {
          display: false,
        }, scales: {
          x: {
            type: 'time', // X-axis is a time scale
            time: {
              unit: 'minute', // Display timestamps by minute
              displayFormats: {
                minute: 'HH:mm', // Format for minute labels (adjust as needed)
              },
            }, title: {
              display: true, text: 'Time', color: labelColor,
            },
          }, y: {
            beginAtZero: true, title: {
              display: true, text: 'Sales', color: labelColor,
            },
          }, xAxes: [
            {
              gridLines: {
                display: false,
              },
            },
          ], yAxes: [
            {
              gridLines: {
                display: false,
              },
            },
          ],
        },
      },
    });
    
    // Function to update chart data
    function updateData()
    {
      // Fetch new sales data from your server using AJAX
      $.ajax({
        url: 'index_charts_sales.php', // Replace with the actual endpoint
        method: 'GET', dataType: 'json', success: function(data) {
          // Process the data and add it to the chart
          const salesData = data; // Assuming the data format is as provided by
                                  // your PHP endpoint
          
          // Extract timestamps and sales values from the data
          const timestamps = salesData.map(item => item.timestamp);
          const salesValues = salesData.map(item => item.sales);
          const costsValues = salesData.map(item => item.costs);
          
          // Update chart labels and data
          salesChart.data.labels = timestamps;
          salesChart.data.datasets[0].data = salesValues;
          salesChart.data.datasets[1].data = costsValues;
          
          // Update the chart
          salesChart.update();
        }, error: function(xhr, status, error) {
          console.error('Error fetching real-time sales data:', error);
        },
      });
    }
    
    // Set up a timer to update the chart data periodically (e.g., every 5
    // seconds)
    setInterval(updateData, 5000); // Adjust the interval as needed
  }
  
  // Call the function to create and initialize the real-time sales chart
  if ($('#realTimeSalesChart').length) {
    createRealTimeChart();
  }
  
  /**********************************************************************
   * ANIMALS
   **********************************************************************/
  $(document).on('click', '.newAnimal', function() {
    $.ajax({
      url: '../forms/animal_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Animal');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitAnimalForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editAnimal', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/animal_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Animal');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitAnimalForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteAnimal', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/animal_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitAnimalForm()
  {
    var formData = $('#animalForm').serialize();
    $.ajax({
      url: '../forms/animal_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Blogs & Articles
   **********************************************************************/
  $(document).on('click', '.newBlog', function() {
    $.ajax({
      url: '../forms/blogs_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Blog Article');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        activateEditor();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitBlogForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.viewBlog', function() {
    $.ajax({
      url: '../forms/blogs_view.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').addClass('modal-lg');
        $('#system-modal .modal-title').html('New Blog Article');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        activateEditor();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitBlogForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editBlog', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/blogs_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Blog');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        activateEditor();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitBlogForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteBlog', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/blogs_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitBlogForm()
  {
    var formData = new FormData($('#blogsForm')[0]); // Use FormData to handle
    // file uploads
    $.ajax({
      url: '../forms/blogs_save.php',
      type: 'post',
      data: formData,
      contentType: false, // Set contentType to false when using FormData
      processData: false, // Set processData to false when using FormData
      success: function(response) {
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Appointments
   **********************************************************************/
  $(document).on('click', '.newAppointment', function() {
    $.ajax({
      url: '../forms/appointment_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Appointment');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitAppointmentForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editAppointment', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/appointment_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Appointment');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitAppointmentForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteAppointment', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/appointment_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitAppointmentForm()
  {
    var formData = $('#appointmentForm').serialize();
    $.ajax({
      url: '../forms/appointment_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Clients
   **********************************************************************/
  $(document).on('click', '.newClient', function() {
    $.ajax({
      url: '../forms/client_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Client');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitClientForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editClient', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/client_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Client');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitClientForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteClient', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/client_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitClientForm()
  {
    var formData = $('#clientForm').serialize();
    $.ajax({
      url: '../forms/client_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Contacts
   **********************************************************************/
  $(document).on('click', '.viewContact', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'contact_view.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').addClass('modal-lg');
        $('#system-modal .modal-title').html('Contact Details');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.replyContact', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'contact_reply.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Reply Contact');
        $('#system-modal .modal-body').html(response);
        activateEditor();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitContactReplyForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteContact', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'contact_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitContactReplyForm()
  {
    var formData = $('#replyForm').serialize();
    $.ajax({
      url: 'contact_reply_send.php',
      type: 'post',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Events
   **********************************************************************/
  $(document).on('click', '.newEvent', function() {
    $.ajax({
      url: '../forms/events_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Event');
        $('#system-modal .modal-body').html(response);
        activateEditor();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitEventForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editEvent', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/events_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Event');
        $('#system-modal .modal-body').html(response);
        activateEditor();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitEventForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.viewEvent', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/events_view.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').addClass('modal-lg');
        $('#system-modal .modal-title').html('Event Details');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.deleteEvent', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/events_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitEventForm()
  {
    var formData = new FormData($('#eventsForm')[0]); // Use FormData to handle
    // file uploads
    $.ajax({
      url: '../forms/events_save.php',
      type: 'post',
      data: formData,
      contentType: false, // Set contentType to false when using FormData
      processData: false, // Set processData to false when using FormData
      success: function(response) {
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Expenses
   **********************************************************************/
  $(document).on('click', '.newExpense', function() {
    $.ajax({
      url: '../forms/expense_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Expense');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitExpenseForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editExpense', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/expense_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Expense');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitExpenseForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteExpense', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/expense_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitExpenseForm()
  {
    var formData = $('#expenseForm').serialize();
    $.ajax({
      url: '../forms/expense_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Inventory
   **********************************************************************/
  $(document).on('click', '.newInventory', function() {
    $.ajax({
      url: '../forms/inventory_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Inventory');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        getCostPrice();
        getSellingPrice();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitInventoryForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editInventory', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/inventory_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Inventory');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        getCostPrice();
        getSellingPrice();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitInventoryForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteInventory', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/inventory_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function getCostPrice()
  {
    // Function to update cost price based on the selected item
    $('#item_name').change(function() {
      // Get the selected option's data attribute for cost price
      var selectedCost = $(this).find(':selected').data('cost');
      
      // Update the cost price input field with the selected cost
      $('#cost_price').val(selectedCost);
    });
  }
  
  function getSellingPrice()
  {
    // Function to update cost price based on the selected item
    $('#item_name').change(function() {
      // Get the selected option's data attribute for cost price
      var selectedCost = $(this).find(':selected').data('selling');
      
      // Update the cost price input field with the selected cost
      $('#selling_price').val(selectedCost);
    });
  }
  
  function submitInventoryForm()
  {
    var formData = $('#inventoryForm').serialize();
    $.ajax({
      url: '../forms/inventory_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Medical Records
   **********************************************************************/
  $(document).on('click', '.newMedicalRecord', function() {
    $.ajax({
      url: '../forms/medical_records_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Medical Record');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitMedicalRecordsForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editMedicalRecord', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/medical_records_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Medical Record');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitMedicalRecordsForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.viewMedicalRecord', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/medical_records_view.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').
            removeClass('modal-lg').
            addClass('modal-dialog-scrollable');
        $('#system-modal .modal-title').html('Animal Medical Record');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.deleteMedicalRecord', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/medical_records_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitMedicalRecordsForm()
  {
    var formData = $('#medicalRecordsForm').serialize();
    $.ajax({
      url: '../forms/medical_records_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Payroll
   **********************************************************************/
  $(document).on('click', '.newPayroll', function() {
    $.ajax({
      url: '../forms/payroll_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Payroll');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitPayrollForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.viewPayroll', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/payroll_view.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').addClass('modal-lg');
        $('#system-modal .modal-title').html('User Payroll Records');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.editPayroll', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/payroll_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Payroll');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitPayrollForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deletePayroll', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/payroll_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitPayrollForm()
  {
    var formData = $('#payrollForm').serialize();
    $.ajax({
      url: '../forms/payroll_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Resources
   **********************************************************************/
  $(document).on('click', '.newResource', function() {
    $.ajax({
      url: 'resources_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Resource');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.editResource', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'resources_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Resource');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.deleteResource', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'resources_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  /**********************************************************************
   * Sales
   **********************************************************************/
  $(document).on('click', '.newSales', function() {
    $.ajax({
      url: '../forms/sales_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').addClass('modal-lg');
        $('#system-modal .modal-title').html('New Sales Record');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitSalesForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editSales', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/sales_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').addClass('modal-lg');
        $('#system-modal .modal-title').html('Update Sales Record');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitSalesForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteSales', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/sales_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitSalesForm()
  {
    var formData = $('#salesForm').serialize();
    $.ajax({
      url: '../forms/sales_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**********************************************************************
   * Stock Movement
   **********************************************************************/
  $(document).on('click', '.newStockMovement', function() {
    $.ajax({
      url: '../forms/stock_movement_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').addClass('modal-lg');
        $('#system-modal .modal-title').html('New Stock Movement');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitStockMovementForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editStockMovement', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/stock_movement_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').addClass('modal-lg');
        $('#system-modal .modal-title').html('Update Stock Movement');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitStockMovementForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteStockMovement', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/stock_movement_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Assess Returns
  $(document).on('click', '.assessStockMovement', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/stock_movement_returns.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').addClass('modal-lg');
        $('#system-modal .modal-title').html('Assessing Stock Movement');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitStockMovementReturnsForm();
          }
        });
      },
    });
  });
  
  function submitStockMovementForm()
  {
    var formData = $('#stockMovementForm').serialize();
    $.ajax({
      url: '../forms/stock_movement_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  function submitStockMovementReturnsForm()
  {
    var formData = $('#stockMovementReturnsForm').serialize();
    $.ajax({
      url: '../forms/stock_movement_returns_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**************************
   * Products
   */
  // Add Product
  $(document).on('click', '.addProductBtn', function() {
    $.ajax({
      url: '../forms/products_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').
            addClass('modal-lg').
            removeClass('modal-xl modal-dialog-scrollable');
        $('#system-modal .modal-title').html('New Product');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        addSMControls();
        $('#system-modal').modal('show');
      },
    });
  });
  // Edit Product
  $(document).on('click', '.editProductBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/products_form.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').
            addClass('modal-lg').
            removeClass('modal-xl modal-dialog-scrollable');
        $('#system-modal .modal-title').html('Edit Product');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        addSMControls();
        $('#system-modal').modal('show');
      },
    });
  });
  // View Product Details and sales
  $(document).on('click', '.viewProductBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/products_view.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').
            removeClass('modal-lg').
            addClass('modal-xl modal-dialog-scrollable');
        $('#system-modal .modal-title').html('Product Details');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        addSMControls();
        activateDataTable();
        $('#system-modal').modal('show');
      },
    });
  });
  // Delete Product
  $(document).on('click', '.deleteProductBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/products_delete.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  /**************************
   * Sales Orders
   */
  // Add Sales Order
  $(document).on('click', '.addSalesOrderBtn', function() {
    $.ajax({
      url: '../forms/sales_orders_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').
            removeClass('modal-lg').
            addClass('modal-xl');
        $('#system-modal .modal-title').html('New Sales Order');
        $('#system-modal .modal-body').html(response);
        salesOrderItems();
        fetchAndAddEmptySalesOrderItem();
        activateSelect();
        addSMControls();
        $('#system-modal').modal('show');
      },
    });
  });
  // View Sales Order Items
  $(document).on('click', '.viewSalesOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/sales_orders_view.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').
            removeClass('modal-lg').
            addClass('modal-xl');
        $('#system-modal .modal-title').html('Sales Order Items');
        $('#system-modal .modal-body').html(response);
        activateDataTable();
        $('#system-modal').modal('show');
      },
    });
  });
  // Cancel Sales Order
  $(document).on('click', '.cancelSalesOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/sales_orders_cancel_order.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Online Orders
   */
  // Add Sales Order
  $(document).on('click', '.viewOnlineOrder', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/online_order_view.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').
            removeClass('modal-lg').
            addClass('modal-xl');
        $('#system-modal .modal-title').html('Online Order Details');
        $('#system-modal .modal-body').html(response);
        activateDataTable();
        $('#system-modal').modal('show');
      },
    });
  });
  
  // Change Online order status
  function updateOnlineOrderStatus()
  {
    // Add event listener to the select element
    $('#order-status').change(function() {
      // Store reference to the select element
      var selectElement = $(this);
      
      // Get the selected status value
      var newStatus = selectElement.val();
      
      // Get the order ID from the table row (assuming each row has a unique ID)
      var orderId = selectElement.closest('tr').data('order-id');
      
      // Send AJAX request to update the status
      $.ajax({
        url: '../forms/online_order_update_status.php', // Replace with the
        // actual URL
        method: 'POST', data: {
          orderId: orderId, newStatus: newStatus,
        }, success: function(response) {
          // Update the text in the status cell with the newly selected status
          selectElement.closest('tr').find('.order-status').text(newStatus);
        }, error: function(xhr, status, error) {
          console.error('Error updating status: ' + error);
        },
      });
    });
  }
  
  /**********************************************************************
   * Profit Management Records
   **********************************************************************/
  $(document).on('click', '.newProfitRecord', function() {
    $.ajax({
      url: '../forms/profit_management_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('New Profit Management Record');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitProfitRecordsForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.editProfitRecord', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/profit_management_form.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').removeClass('modal-lg');
        $('#system-modal .modal-title').html('Update Profit Management Record');
        $('#system-modal .modal-body').html(response);
        $('#system-modal').modal('show');
        // Initialize validation for the dynamically loaded form
        var forms = $('.needs-validation');
        forms.on('submit', function(event) {
          if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          else {
            $(this).addClass('was-validated');
            event.preventDefault();
            // Submit if the form is valid
            submitProfitRecordsForm();
          }
        });
      },
    });
  });
  
  $(document).on('click', '.deleteProfitRecord', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/profit_management_delete.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function submitProfitRecordsForm()
  {
    var formData = $('#profitManagementForm').serialize();
    $.ajax({
      url: '../forms/profit_management_save.php',
      type: 'post',
      data: formData,
      success: function(response) {
        
        if (response.status === 'success') {
          $('#system-modal').modal('hide');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  }
  
  /**************************
   * Users
   */
  // Add User
  $(document).on('click', '.newUser', function() {
    $.ajax({
      url: '../forms/users_form.php',
      type: 'post',
      success: function(response) {
        $('#system-modal .modal-dialog').
            addClass('modal-lg').
            removeClass('modal-xl').
            removeClass('modal-dialog-scrollable');
        $('#system-modal .modal-title').html('New User');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        addSMControls();
        $('#system-modal').modal('show');
      },
    });
  });
  // View User Details & Audit Trails
  $(document).on('click', '.viewUserBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/users_view.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').
            removeClass('modal-lg').
            addClass('modal-xl').
            addClass('modal-dialog-scrollable');
        $('#system-modal .modal-title').html('User Audit Trails');
        $('#system-modal .modal-body').html(response);
        activateDataTable();
        $('#system-modal').modal('show');
      },
    });
  });
  // Edit User
  $(document).on('click', '.editUser', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/users_form.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#system-modal .modal-dialog').
            addClass('modal-lg').
            removeClass('modal-xl').
            removeClass('modal-dialog-scrollable');
        $('#system-modal .modal-title').html('Edit User');
        $('#system-modal .modal-body').html(response);
        activateSelect();
        addSMControls();
        $('#system-modal').modal('show');
      },
    });
  });
  // Delete User
  $(document).on('click', '.deleteUser', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/users_delete.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**********************************************************************************
   * System Management
   */
  $(document).on('click', '.clearTrails', function() {
    $.ajax({
      url: '../forms/system_clear_audit_trails.php',
      type: 'post',
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  /**************************
   * SALES ORDER THINGS
   */
  function salesOrderItems()
  {
    const addItemBtn = document.getElementById('addItemBtn');
    const itemForm = document.getElementById('salesOrderForm');
    
    // Add event listener to the Add Item button
    addItemBtn.addEventListener('click', function(event) {
      event.preventDefault();
      fetchAndAddEmptySalesOrderItem();
    });
    
    // Add event listener for calculating totals
    itemForm.addEventListener('input', function(event) {
      calculateSalesOrderItemTotal(event.target);
      calculateSalesOrderGrandTotal();
    });
  }
  
  async function fetchProducts()
  {
    try {
      const response = await fetch('../forms/sales_order_get_products.php');
      const data = await response.json();
      return data;
    }
    catch (error) {
      console.error('Error fetching products:', error);
      return []; // Return an empty array on error
    }
  }
  
  function fetchAndAddEmptySalesOrderItem()
  {
    fetchProducts().then(products => {
      addEmptySalesOrderItem(products);
    }).catch(error => {
      console.error('Error fetching products:', error);
    });
  }
  
  function addEmptySalesOrderItem(products)
  {
    const itemsDiv = $('.salesOrderItems');
    const newRow = $('<div class="itemRow row"></div>');
    const newProductCombo = $(
        '<div class="col-sm-3"><div class="form-group"><select name="product[]" class="form-control productCombo"></select></div></div>');
    populateProductCombo(newProductCombo, products);
    newRow.append(newProductCombo);
    newRow.append(
        '<div class="col-sm-2"><div class="form-group"><input type="number" name="quantity[]" placeholder="Quantity" class="quantity form-control form-control-sm"></div></div>');
    newRow.append(
        '<div class="col-sm-3"><div class="form-group"><input type="number" name="selling_price[]" placeholder="Selling Price" class="selling_price form-control form-control-sm"></div></div>');
    newRow.append(
        '<div class="col-sm-3"><div class="form-group"><input type="number" name="total_amount[]" placeholder="Total Amount" readonly class="total_amount form-control form-control-sm"></div></div>');
    newRow.append(
        '<div class="col-sm-1"><button type="button" class="removeItemBtn btn btn-link text-danger btn-xs"><span class="fa fa-trash-alt"></span></button></div>');
    itemsDiv.append(newRow);
    
    // Initialize select2 for the cloned combo box
    newProductCombo.find('select').select2({
      width: '100%',
    });
  }
  
  function calculateSalesOrderItemTotal(inputElement)
  {
    const row = inputElement.closest('.itemRow');
    if (row.length > 0) {
      const quantity = parseFloat(row.find('.quantity').val()) || 0;
      const unitCost = parseFloat(row.find('.selling_price').val()) || 0;
      const totalAmount = quantity * unitCost;
      row.find('.total_amount').val(totalAmount.toFixed(2)); // Optional:
                                                             // Update the
                                                             // input field
      calculateSalesOrderGrandTotal();
    }
  }
  
  function calculateSalesOrderGrandTotal()
  {
    let grandTotal = 0;
    $('.total_amount').each(function() {
      grandTotal += parseFloat($(this).val()) || 0;
    });
    $('#grandTotal span').text(grandTotal.toFixed(2)); // Update the span
                                                       // element inside
                                                       // #grandTotal
  }
  
  function populateProductCombo(productCombo, products)
  {
    productCombo.find('select').
        append('<option value="">Select a product</option>');
    $.each(products, function(key, product) {
      productCombo.find('select').
          append(
              `<option value="${product.product_id}" data-selling-price="${product.selling_price}">${product.product_name}</option>`);
    });
  }
  
  $(document).on('change', '.productCombo', function() {
    const productCombo = $(this);
    const row = productCombo.closest('.itemRow');
    const selectedProduct = productCombo.val();
    const sellingPrice = productCombo.find(`option:selected`).
        data('selling-price');
    row.find('.selling_price').val(sellingPrice);
    calculateSalesOrderItemTotal(productCombo);
  });
  
  $(document).on('input', '.quantity, .unit_price, .selling_price', function() {
    calculateSalesOrderItemTotal($(this));
  });
  
  $(document).on('click', '.removeSalesOrderItemBtn', function() {
    $(this).closest('.itemRow').remove();
    calculateSalesOrderGrandTotal();
  });
  
  // Add event listener to the Remove button for dynamically added rows
  $(document).on('click', '.removeItemBtn', function() {
    $(this).closest('.itemRow').remove();
    calculateSalesOrderGrandTotal();
  });
  
  /**************************
   * Password - Profile Page
   */
  if ($('#retype').length) {
    // Workout the matching passwords and character counting
    // Check if passwords are matching
    $('#passSubmit').addClass('disabled');
    
    function checkPasswordMatch()
    {
      var password = $('#new').val();
      var confirmPassword = $('#retype').val();
      
      if (password != confirmPassword) {
        $('#divCheckPasswordMatch').html('Passwords do not match<br>');
        $('#passSubmit').prop('disabled', true);
      }
      else {
        if ((password == confirmPassword) && (password.length < 8)) {
          $('#divCheckPasswordMatch').
              html('Password must be 8 characters or more<br>');
          $('#passSubmit').prop('disabled', true);
        }
        else {
          $('#divCheckPasswordMatch').html('');
          $('#passSubmit').prop('disabled', false);
          $('#passSubmit').removeClass('disabled');
        }
      }
    }
    
    $(document).ready(function() {
      $('#retype').keyup(checkPasswordMatch);
    });
  }
  
  // Working on forms
  $(document).on('click', '.newExpensesCategory', function() {
    // Do some ajax
    $('#system-modal .modal-dialog').addClass('modal-lg');
    $('#system-modal .modal-title').html('New Expense Category');
    $('#system-modal .modal-body').
        html('<h3>Some html Content for the new category</h3>');
    $('#system-modal').modal('show');
  });
})(jQuery);
