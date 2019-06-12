function tree_toggle(event) {
    event = event || window.event
    var clickedElem = event.target || event.srcElement
 
    if (!hasClass(clickedElem, 'Expand')) {
        return // êëèê íå òàì
    }
 
    // Node, íà êîòîðûé êëèêíóëè
    var node = clickedElem.parentNode
    if (hasClass(node, 'ExpandLeaf')) {
        return // êëèê íà ëèñòå
    }
 
    // îïðåäåëèòü íîâûé êëàññ äëÿ óçëà
    var newClass = hasClass(node, 'ExpandOpen') ? 'ExpandClosed' : 'ExpandOpen'
    // çàìåíèòü òåêóùèé êëàññ íà newClass
    // ðåãåêñï íàõîäèò îòäåëüíî ñòîÿùèé open|close è ìåíÿåò íà newClass
    var re =  /(^|\s)(ExpandOpen|ExpandClosed)(\s|$)/
    node.className = node.className.replace(re, '$1'+newClass+'$3')
}
 
 
function hasClass(elem, className) {
    return new RegExp("(^|\\s)"+className+"(\\s|$)").test(elem.className)
}