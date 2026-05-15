<div class="card">
    <div class="card-body text-center">
        <div class="error-wrapper">
            <div class="error-header">
                <i class="las la-exclamation-triangle error-icon"></i>
                <h1 class="error-title">@lang('404')</h1>
            </div>
            <p class="error-text">@lang('Oops! The page you are looking for could not be found.')</p>
            <p class="error-hint">@lang('You may not have permission to access this page or it doesn\'t exist.')</p>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        margin: 2rem auto;
        max-width: 600px;
    }

    .error-wrapper {
        padding: 3rem 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 400px;
    }

    .error-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .error-icon {
        font-size: 80px;
        color: #dc3545;
        animation: shake 0.5s ease-in-out;
    }

    .error-title {
        font-size: 80px;
        font-weight: 700;
        color: #343a40;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .error-text {
        font-size: 26px;
        color: #6c757d;
        margin-bottom: 0.75rem;
    }

    .error-hint {
        font-size: 18px;
        color: #6c757d;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-10px);
        }

        75% {
            transform: translateX(10px);
        }
    }
</style>
