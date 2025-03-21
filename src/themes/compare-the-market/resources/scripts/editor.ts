const { select, dispatch, subscribe } = wp.data;

const UpdateEditorPanels = () => {
    let wpDataEditPostDispatch = dispatch('core/edit-post');
    let wpDataEditorSelect = select('core/editor');

    // wpDataEditPostDispatch.removeEditorPanel( 'taxonomy-panel-category' ) ; // category
    // wpDataEditPostDispatch.removeEditorPanel( 'taxonomy-panel-post_tag' ); // tags
    wpDataEditPostDispatch.removeEditorPanel( 'taxonomy-panel-partner' ); // partner
    wpDataEditPostDispatch.removeEditorPanel( 'post-link' ); // permalink
    // wpDataEditPostDispatch.removeEditorPanel( 'page-attributes' ); // page attributes
    wpDataEditPostDispatch.removeEditorPanel( 'post-excerpt' ); // Excerpt
    wpDataEditPostDispatch.removeEditorPanel( 'discussion-panel' ); // Discussion
    // wpDataEditPostDispatch.removeEditorPanel( 'template' ); // Template
    wpDataEditPostDispatch.removeEditorPanel( 'post-last-revision' ); // revisions

    /* Yoast SEO */
    wpDataEditPostDispatch.removeEditorPanel( 'yoast-seo/document-panel' );

    /* Template - Specific */
    let pageTemplate = wpDataEditorSelect.getEditedPostAttribute('template');
    if ('partner.blade.php' == pageTemplate) {
        wpDataEditPostDispatch.removeEditorPanel( 'featured-image' ); // featured image
    }
}

document.addEventListener("DOMContentLoaded", () => {
    subscribe(()=>{
        UpdateEditorPanels();
    })
});