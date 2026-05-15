<ul class="social-list style-two">
    <li>
        <a href="http://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}&p[title]={{ slug($itemDetails->name) }}"
            target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>
    </li>
    <li>
        <a href="http://twitter.com/share?text={{ slug($itemDetails->name) }}&url={{ urlencode(url()->current()) }}"
            target="_blank">
            <i class="fab fa-twitter"></i>
        </a>
    </li>
    <li>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ slug($itemDetails->name) }}"
            target="_blank">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </li>
    <li>
        <a href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ slug($itemDetails->name) }}"
            target="_blank">
            <i class="fab fa-pinterest-p"></i>
        </a>
    </li>
</ul>
