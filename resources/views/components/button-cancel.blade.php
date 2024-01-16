<button {{ $attributes->merge(['type' => 'button', 'class' => 'button-cancel', 'onclick' => 'cancelAction("'.$cancelRoute.'")']) }}>
    {{ $slot }}
</button>

<style>
    .button-cancel{
        display: inline-flex;
        items: center;
        padding: 0.5rem 1rem;
        background-color: rgb(160, 160, 160);
        border: 1px solid transparent;
        border-radius: 0.375rem; /* Equivalent to rounded-md */
        font-weight: 600; /* Equivalent to font-semibold */
        font-size: 0.75rem; /* Equivalent to text-xs */
        text-transform: uppercase;
        letter-spacing: 0.05em; /* Equivalent to tracking-widest */
        color: black; /* Default text color for light mode */
        transition: background-color 0.15s ease-in-out;
    }
    .button-cancel:hover,
    .button-cancel:focus {
        background-color: #43494e; /* Equivalent to hover:bg-gray-200 */
        border-color: transparent;
        color: white;
        outline: none;
    }

    .button-cancel:active {
        background-color: #e2e8f0; /* Equivalent to active:bg-gray-300 */
    }

    .dark-mode .button-cancel {
        background-color: #2d3748; /* Equivalent to dark:bg-gray-800 */
        border-color: transparent;
        color: white; /* Text color for dark mode */
    }

    .dark-mode .button-cancel:hover,
    .dark-mode .button-cancel:focus {
        background-color: #4a5568; /* Equivalent to dark:hover:bg-gray-700 */
    }

    .dark-mode .button-cancel:active {
        background-color: #1a202c; /* Equivalent to dark:active:bg-gray-900 */
    }
</style>

<script>
    function cancelAction(route)
    {
        if(route){
            window.location.href = route;
        }
        else{
            window.history.back();
        }
    }
</script>