<style>
     .scrollbar
    {
        margin-left: 30px;
        float: left;
        height: 300px;
        width: 200px;
        background: #F5F5F5;
        overflow-y: scroll;
        margin-bottom: 25px;
    }

    .force-overflow
    {
        min-height: 450px;
    }

    #wrapper
    {
        text-align: center;
        width: 500px;
        margin: auto;
    }

    #style-6::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5;
    }

    #style-6::-webkit-scrollbar
    {
        width: 10px;
        background-color: #F5F5F5;
    }

    #style-6::-webkit-scrollbar-thumb
    {
        background-color: #F90;	
        background-image: -webkit-linear-gradient(45deg,
            rgba(255, 255, 255, .2) 25%,
            transparent 25%,
            transparent 50%,
            rgba(255, 255, 255, .2) 50%,
            rgba(255, 255, 255, .2) 75%,
            transparent 75%,
            transparent)
    }



</style>


<div class="scrollbar" id="style-6">
    <div class="force-overflow">dfgdgdfgfdsgfdsgdaftyge fgfdagdfag dfdgdfagdfagdfg dfgdfa </div>
</div>