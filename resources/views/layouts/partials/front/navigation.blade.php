<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-dark navbar-custom fixed-top">
    <!-- Text Logo - Use this if you don't have a graphic logo -->
    <!-- <a class="navbar-brand logo-text page-scroll" href="index.html">Leno</a> -->

    <!-- Image Logo -->
    <a class="navbar-brand logo-image" href="{{route('home')}}"><img src="{{asset('front/images/logo.svg')}}" alt="TFC Logo" title="Turkish Food Company"></a>

    <!-- Mobile Menu Toggle Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-awesome fas fa-bars"></span>
        <span class="navbar-toggler-awesome fas fa-times"></span>
    </button>
    <!-- end of mobile menu toggle button -->

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link page-scroll" href="{{route('home')}}#header">HOME <span class="sr-only">(current)</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link page-scroll" href="{{route('home')}}#contact">CONTACT</a>
            </li>
        </ul>

    </div>
</nav> <!-- end of navbar -->
<!-- end of navigation -->
