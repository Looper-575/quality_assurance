"use strict";
// Tables Multi Checkboxes
let block_loader = (function () {/*
<div id="block_loader">
    <div className="overlay-bg"></div>
    <div className="overlay" id="loading">
        <div className="d-flex justify-content-center">
            <div className="spinner-border" role="status">
                <span className="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>
*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];

function toggle_block_loader(status, id=null){
    if(status === 'hide'){
        $(id).removeClass('block-loader');
        $('#block_loader').remove();
        return
    }
    $(id).addClass('block-loader');
    $(id).append(block_loader);
}



