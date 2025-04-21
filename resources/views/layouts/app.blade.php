<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SPA jQuery</title>
    <style>
        .loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            font-size: 18px;
        }
        nav a.active { font-weight: bold; }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('home') }}" class="nav-link">Home</a> |
    <a href="{{ route('products') }}" class="nav-link">Browse Products</a>
</nav>

<div class="loading" id="loading">Loading...</div>

<div id="main-content">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function setActiveNav(url) {
        $('nav a').removeClass('active');
        $('nav a[href="' + url + '"]').addClass('active');
    }

    function loadPage(url, push = true) {
        $('#loading').show();

        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (data) {

                console.log("Data loaded successfully: " , data);

                let mainContentHtml = $(data).find('#main-content').html();
                console.log("Main Content HTML ", mainContentHtml);

                $('#main-content').html(data);

                if (push) {
                    history.pushState(null, '', url);
                }

                setActiveNav(url);
            },
            error: function () {
                alert('Failed to load content.');
            },
            complete: function () {
                $('#loading').hide();
            }
        });
    }

    $(document).on('click', 'a.nav-link, a.ajax-link', function (e) {
        const url = $(this).attr('href');
        if (url.startsWith(window.location.origin)) {
            e.preventDefault();
            loadPage(url);
        }
    });

    window.onpopstate = function () {
        loadPage(location.pathname + location.search, false);
    };
</script>
</body>
</html>
