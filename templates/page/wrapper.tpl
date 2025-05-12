{include file='page/header.tpl'}

<!-- Ensure that the wrapper takes full height -->
<div style="display: flex; flex-direction: column; min-height: 100vh;">
    
    <!-- Main content area, flex-grow ensures it takes available space -->
    <div style="flex-grow: 1;">
        {include file=$content}
    </div>

    <!-- Include footer -->
    {include file='page/footer.tpl'}

</div>