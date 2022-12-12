{"version":3,"sources":["text.js"],"names":["BX","namespace","escapeText","Landing","Utils","headerTagMatcher","Matchers","headerTag","changeTagName","textToPlaceholders","Block","Node","Text","options","apply","this","arguments","onClick","bind","onPaste","onDrop","onInput","onMousedown","onMouseup","node","addEventListener","document","currentNode","prototype","__proto__","superClass","constructor","onAllowInlineEdit","setAttribute","message","onChange","preventAdjustPosition","preventHistory","call","UI","Panel","EditorPanel","getInstance","adjustPosition","History","push","Entry","block","getBlock","id","selector","command","undo","lastValue","redo","getValue","event","clearTimeout","inputTimeout","key","keyCode","which","top","window","navigator","userAgent","match","ctrlKey","metaKey","setTimeout","onEscapePress","isEditable","hide","disableEdit","preventDefault","text","clipboardData","getData","manifest","textOnly","replace","RegExp","execCommand","onDocumentClick","fromNode","allowInlineEdit","Main","isControlsEnabled","stopPropagation","enableEdit","Tool","ColorPicker","hideAll","Button","FontAction","requestAnimationFrame","target","nodeName","parentElement","range","createRange","selectNode","getSelection","removeAllRanges","addRange","isContentEditable","StylePanel","isShown","buttons","getDesignButton","isHeader","getChangeTagButton","changeHandler","onChangeTag","show","contentEditable","focus","designButton","Design","html","attrs","title","onDesignShow","code","isAllowInlineEdit","getField","field","Field","name","content","innerHTML","changeTagButton","setValue","value","preventSave","isSavePrevented","test","ChangeTag","insertAfter","activateItem","data","changeOptionsHandler"],"mappings":"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","file":""}