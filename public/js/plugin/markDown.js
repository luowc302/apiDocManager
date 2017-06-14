/**
 * 
 * markdown转html
 * @returns {undefined}
 */
function markDownTohtm(){
    $(function () {
    testEditormdView2 = editormd.markdownToHTML("test-editormd-view2", {
        htmlDecode: "style,script,iframe", // you can filter tags decode
        emoji: true,
        taskList: true,
        tex: true, // 默认不解析
        flowChart: true, // 默认不解析
        sequenceDiagram: true, // 默认不解析
    });
});
}

/**
 * markdon配置
 * @returns {undefined}
 */
function editorConfig() {
    var testEditor;
    $(function () {
        testEditor = editormd("page-editormd", {
            width: "90%",
            height: 640,
            syncScrolling: "single",
            path: "../editor.md-master/lib/",
            toolbarIcons: function () {
                return [
                    "undo", "redo", "|",
                    "bold", "quote", "del", "|",
                    "list-ol", "list-ul", "hr", "|",
                    "h1", "h2", "h3", "h4", "h5", "h6", "|",
                    "preview", "watch", "search", "|", 
                    "clear"
                ]
            },
        });
    });
}