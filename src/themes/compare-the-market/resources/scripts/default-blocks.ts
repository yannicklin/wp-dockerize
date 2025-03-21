interface Window {
    __atlas: {
      blocks: string[]
    },
}

function addAllDefaultBlocks() {
  let editedPostContentIsEmpty = wp.data.select("core/editor").getEditedPostContent() === "";
  let currentPostContentIsEmpty = wp.data.select("core/editor").getCurrentPost().content === "";

  if(!editedPostContentIsEmpty || !currentPostContentIsEmpty || !window.__atlas.blocks.length) {
    return;
  }

  // reset all blocks on the page
  wp.data.dispatch("core/block-editor").resetBlocks([]);

  // find blocks that should be on this page, loop over them and then insert them into it
  window.__atlas.blocks.forEach(blockName => {
    if(!wp.blocks.getBlockType(blockName)) {
      console.warn(`Block ${blockName} not found`);
      return;
    }

    const block = wp.blocks.createBlock(blockName, {
      mode: "edit"
    });
    wp.data.dispatch("core/block-editor").insertBlocks(block);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  requestIdleCallback(addAllDefaultBlocks, {
    timeout: 500
  });
});
