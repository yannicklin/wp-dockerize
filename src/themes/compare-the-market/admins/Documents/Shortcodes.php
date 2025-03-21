<?php

namespace Admins\Documentation;

class Shortcodes
{

    public static function page_menu()
    {
        return <<<PAGE_MENU
        <ul class="sub-menu">
            <li><a href="#page_title">[page_title]</a></li>
            <li><a href="#read_more">[read_more]</a></li>
            <li><a href="#strong">[b] or [strong]</a></li>
            <li><a href="#em">[em]</a></li>
            <li><a href="#br">[br]</a></li>
            <li><a href="#a">[a]</a></li>
            <li><a href="#span">[span]</a></li>
            <li><a href="#jump">[jump]</a></li>
            <li><a href="#style">[style]</a></li>
            <li><a href="#current_year">[current_year]</a></li>
            <li><a href="#CTM_copyright">[CTM_copyright]</a></li>
            <li><a href="#partner">[partner]</a></li>
            <li><a href="#partners">[partners]</a></li>
            <li><a href="#lvr_calculator">[lvr_calculator]</a></li>
            <li><a href="#icon">[icon]</a></li>
            <li><a href="#health_opening_hours">[health_opening_hours]</a></li>
            <li><a href="#button">[button]</a></li>
        </ul>
PAGE_MENU;
    }

    public static function content()
    {
        return <<<PAGE_CONTENT
        <div class="ctm">

            <div id="page_title" class="sep">
                <h2><pre>[page_title]</pre></h2>

                <p>Render the current Page title</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>None</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[page_title]</pre>
            </div>

            <div id="read_more" class="sep">
                <h2><pre>[read_more][/read_more]</pre></h2>

                <p>Create Read More section</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>None</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[read_more] ... content [/read_more]</pre>
            </div>

            <div id="strong" class="sep">
                <h2><pre>[strong][/strong] or [b][/b]</pre></h2>

                <p>Bold the content text</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>None</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[strong] ... content [/strong]</pre>
            </div>

            <div id="em" class="sep">
                <h2><pre>[em][/em]</pre></h2>

                <p>emphasize/Italic the content text</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>None</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[em] ... content [/em]</pre>
            </div>

            <div id="br" class="sep">
                <h2><pre>[br]</pre></h2>

                <p>Insert a single lint break</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>None</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[br]</pre>
            </div>

            <div id="a" class="sep">
                <h2><pre>[a][/a]</pre></h2>

                <p>Insert a single lint break</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>href: The URL</li>
                    <li>id: The (unique) archor</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[a href="/here-to-test/"]Link Test over here[/a]</pre>
            </div>

            <div id="a" class="span">
                <h2><pre>[span][/span]</pre></h2>

                <p>generate a SPAN wrapper</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>id</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[span id="span-001"] ... content [/span]</pre>
            </div>

            <div id="jump" class="span">
                <h2><pre>[jump][/jump]</pre></h2>

                <p>Create an anchor-enabled span wrapper</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>id</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[jump id="span-001"] ... content [/jump]</pre>
            </div>

            <div id="style" class="span">
                <h2><pre>[style][/style]</pre></h2>

                <p>Create a span wrapper with online style(s)</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>style: the online style css</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[style style="color:black;"] ... content [/style]</pre>
            </div>

            <div id="current_year" class="sep">
                <h2><pre>[current_year]</pre></h2>

                <p>Get the current Year</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>None</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[current_year]</pre>
            </div>

            <div id="CTM_copyright" class="sep">
                <h2><pre>[CTM_copyright]</pre></h2>

                <p>Get a predefined CTM copyright sentence, for example: © 2024 Compare The Market. All rights reserved. ACN: 117 323 378 AFSL: 422926 ACL: 422926</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>None</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[CTM_copyright]</pre>
            </div>

            <div id="partner" class="sep">
                <h2><pre>[partner]</pre></h2>

                <p>Returns an image with a given partner logo, or the display name of the partner.</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>type: "logo" or "name" - default: logo</li>
                    <li>source: seek the partner by "slug" or "id" - default: slug</li>
                    <li>slug: the slug of the partner</li>
                    <li>id: the term_id of the partner</li>
                </ul>
                <p>Note: The name needs to be the same as the provider setup in the CTM system. For more information click here to see a list of current providers.</p>
                <p class="usage">Usage:</p>
                <pre class="source">[partner type="logo" source="slug" slug="bupa"] or [partner type="name" source="id" id="123"]</pre>
            </div>

            <div id="partners" class="sep">
                <h2><pre>[partners]</pre></h2>

                <p>Get the whole exising(active) Partners of certain Vertical in text list</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>vertical: vertical slug (required) -</li>
                    <li>list_mode:
                        <ul>
                            <li>ol, this is the default option</li>
                            <li>ul</li>
                            <li>ol-link: list in number list, also all list element has the link as /vertical-slug/partner-slug/</li>
                            <li>ul-link: list in bullet list, also all list element has the link as /vertical-slug/partner-slug/</li>
                        </ul>
                    </li>
                    <li>sort: sorting direction
                        <ul>
                            <li>ascend, this is the default option</li>
                            <li>descend</li>
                        </ul>
                </ul>
                <p>Note: The name needs to be the same as the provider setup in the CTM system. For more information click here to see a list of current providers.</p>
                <p class="usage">Usage:</p>
                <pre class="source">[partners vertical="car-insurance" list_mode="ol" sort="descend"]</pre>
            </div>

            <div id="lvr_calculator" class="sep">
                <h2><pre>[lvr_calculator]</pre></h2>

                <p>Render the LVR Calculator</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>None</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[lvr_calculator]</pre>
            </div>

            <div id="icon" class="sep">
                <h2><pre>[icon]</pre></h2>

                <p>Display cross or check icon</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>value: Yes icon is green-check, no is red-cross.</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[icon type="green-check"] for yes [icon type="red-cross"] for a cross</pre>
            </div>

            <div id="health_opening_hours" class="sep">
                <h2><pre>[health_opening_hours]</pre></h2>

                <p>Get the whole exising(active) Partners of certain Vertical in text list</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>id: optional, default is prefix "ctm-health_opening_hours-" and a random number, will be generated automatically if not set</li>
                    <li>api: optional, default is the value of "opening_hours_api" field in the theme options</li>
                    <li>class: optional, as "text-center" or "text-greyscale-400"</li>
                    <li>wrapper: default is "div", but you can use any valid HTML tag, like "p" or "span"</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[health_opening_hours id="car-insurance" api="ol" class="body-m" wrapper="span" ]</pre>
            </div>

            <div id="button" class="sep">
                <h2><pre>[button] <a href="#button"></a></pre></h2>

                <p>Returns the HTML to output a button, either as a "a" or "button" element.</p>
                <p>Parameters:</p>
                <ul class="params">
                    <li>text: The content for the button</li>
                    <li>Id: A unique identifier for an HTML element, used for JavaScript manipulation or targeted styling</li>
                    <li>link: The URL for the button to point to</li>
                    <li>size: The size of the button, default is medium</li>
                    <ul>
                        <li>small</li>
                        <li>medium</li>
                        <li>large</li>
                    </ul>
                    <li>tag: The HTML tag used to render the element ('a' or 'button'). The default is a.</li>
                    <li>Type: The type and color of button</li>
                    <ul>
                        <li>primary</li>
                        <li>secondary</li>
                        <li>neutral</li>
                        <li>hero</li>
                        <li>text</li>
                        <li>link</li>
                    </ul>
                    <li>Class: CSS classes applied to an element for styling.</li>
                    <li>rel: Any rel value you wish to add to the button</li>
                    <li>icon: The icon you wish to add with the text like fa-star or fa-check. You can find icons at fontawesome.com</li>
                    <li>icon_position: The position of the icon, left or right. The default is left.</li>
                    <li>aria_label: An accessibility attribute</li>
                </ul>
                <p class="usage">Usage:</p>
                <pre class="source">[button text="Click Me" link="https://comparethemeerkats.com" type="primary" size="large" class="custom-class" id="unique-id" rel="nofollow" aria_label="Example Button" icon="fa-check-circle" icon_position="right" tag="a"]</pre>
            </div>

        </div>
PAGE_CONTENT;
    }
}
