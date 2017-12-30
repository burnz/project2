this["JST"] = this["JST"] || {};
this["JST"]["assets/templates/tree-node-leaf.html"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    var cl='right-posi';
    var dis='';
    if(obj.username=='')
        dis='disable-tt';
    if(obj.posi=='right')
        cl='left-posi';
    with(obj) {
        __p += '<div class="wp-node-loyalty"><div class="node-loyalty node-loyalty-'+loyaltyId+'"><div class="node-name node-lvl-' +
            ((__t = (level)) == null ? '' : __t) + '"' +  (username == '' ? '' : 'style="border-bottom: 1px solid; color: #3c8dbc"') +'>' + (username == '' ? '' : '<i class="fa fa-user" style="margin-right: 3px; color: gold"></i>') +
            ((__t = (username)) == null ? '' : __t) + '</div>\n<p class="node-title">' +
            ((__t = (pkg)) == null ? '' : __t) + '</p>\n<div class="node-info '+cl+' '+dis+'"><div class="tooltip-arrow"></div><div class="tooltip-content"><div class="tooltip-content-title"><p class="node-if-header">Informations</p></div><div class="tooltip-content-body"><div><p>Total Infinity</p><p class="ptext text-left tt-saleLeft"><label class="lb-tt-tt">L:</label>$'+((__t = (lSale)) == null ? '' : __t)+'</p><p class="ptext text-left tt-saleRight"><label class="lb-tt-tt">R:</label>$'+((__t = (rSale)) == null ? '' : __t)+'</p></div><div><p>Total Infinity Interest</p><p class="ptext text-left tt-saleLeft"><label class="lb-tt-tt">L:</label>$'+((__t = (ifLeft)) == null ? '' : __t)+'</p><p class="ptext text-left tt-saleRight"><label class="lb-tt-tt">R:</label>$'+((__t = (ifRight)) == null ? '' : __t)+'</p></div></div></div></div></div></div>\n';
    }
    return __p
};
this["JST"]["assets/templates/tree-node.html"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    var cl='right-posi';
    var dis='';
    if(obj.username=='')
        dis='disable-tt';
    if(obj.posi=='right')
        cl='left-posi';
    with(obj) {
        __p += '<div class="wp-node-loyalty"><div class="node-loyalty node-loyalty-'+loyaltyId+'"><div class="node-name node-lvl-' +
            ((__t = (level)) == null ? '' : __t) + '"' +  (username == '' ? '' : 'style="border-bottom: 1px solid; color: #3c8dbc"') +'>' + (username == '' ? '' : '<i class="fa fa-user" style="margin-right: 3px; color: gold"></i>') +
            ((__t = (username)) == null ? '' : __t) + '</div>\n<p class="node-title">' +
            ((__t = (pkg)) == null ? '' : __t) + '</p>\n<div class="node-info '+cl+' '+dis+'"><div class="tooltip-arrow"></div><div class="tooltip-content"><div class="tooltip-content-title"><p class="node-if-header">Informations</p></div><div class="tooltip-content-body"><div><p>Total Infinity</p><p class="ptext text-left tt-saleLeft"><label class="lb-tt-tt">L:</label>$'+((__t = (lSale)) == null ? '' : __t)+'</p><p class="ptext text-left tt-saleRight"><label class="lb-tt-tt">R:</label>$'+((__t = (rSale)) == null ? '' : __t)+'</p></div><div><p>Total Infinity Interest</p><p class="ptext text-left tt-saleLeft"><label class="lb-tt-tt">L:</label>$'+((__t = (ifLeft)) == null ? '' : __t)+'</p><p class="ptext text-left tt-saleRight"><label class="lb-tt-tt">R:</label>$'+((__t = (ifRight)) == null ? '' : __t)+'</p></div></div></div></div></div></div>\n';
    }
    return __p
};