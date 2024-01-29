<?php

/**
 * The Features Timeline Shortcode.
 */

use Aheto\Helper;

extract($atts);

$vestry_timeline = $this->parse_group($vestry_timeline);
if (empty($vestry_timeline)) {
	return '';
}


$this->generate_css();

$vestry_dark_version = isset($vestry_dark_version) && $vestry_dark_version ? 'dark-version' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-timeline--vestry-modern');
$this->add_render_attribute('wrapper', 'class', $vestry_dark_version);


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/features-timeline/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'vestry-features-timeline-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null );
}
wp_enqueue_script( 'vestry-features-timeline-layout1-js', $shortcode_dir . 'assets/js/vestry_layout1.min.js', array( 'jquery' ), null );

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<section class="aheto-timeline--vestry-modern">
		<div class="aheto-timeline__events-content">
			<ol>
				<?php
				$counter = 1;
				foreach ($vestry_timeline as $item) :
					$item = wp_parse_args($item, [
						'vestry_timeline_date'    => '',
						'vestry_timeline_image'   => '',
						'vestry_timeline_title'   => '',
						'vestry_timeline_content' => '',
						'vestry_add_button'       => '',
					]);
					extract($item);
					if ($counter === 1) { ?>
						<li class="selected" data-date="<?php echo esc_attr($vestry_timeline_date); ?>">
						<?php } else { ?>
						<li data-date="<?php echo esc_attr($vestry_timeline_date); ?>">
						<?php } ?>
						<div class="aheto-timeline__wrap">
							<div class="aheto-timeline__image-wrap">
								<?php if (!empty($vestry_timeline_image)) { ?>
									<?php echo Helper::get_attachment($vestry_timeline_image, ['class' => 'aheto-timeline-slider__add-image'], $vestry_image_size, $atts, 'vestry_'); ?>
								<?php } ?>
							</div>
							<div class="aheto-timeline__content">
								<?php if (!empty($vestry_article_date)) { ?>
									<p class="aheto-timeline__subtitle"><?php echo esc_html( $vestry_article_date ); ?></p>
								<?php }
								if (!empty($vestry_timeline_title)) { ?>
									<h3 class="aheto-timeline__title"><?php echo esc_html($vestry_timeline_title); ?></h3>
								<?php }
								if (!empty($vestry_timeline_content)) { ?>
									<p class="aheto-timeline__desc"><?php echo esc_html($vestry_timeline_content); ?></p>
								<?php } ?>
							</div>
						</div>
						</li>
					<?php
					$counter++;
				endforeach; ?>
			</ol>
		</div> <!-- .events-content -->
		<div class="aheto-timeline__timeline">
			<div class="aheto-timeline__events-wrapper">
				<div class="aheto-timeline__events">
					<ol>
						<?php
						$counter = 1;
						foreach ($vestry_timeline as $item) :
							$item = wp_parse_args($item, [
								'vestry_timeline_date' => '',
							]);
							extract($item);
							if ($counter === 1) { ?>
								<li><a href="#0" class="selected" data-date="<?php echo esc_attr($vestry_timeline_date); ?>">
										<h5><?php echo esc_html($vestry_timeline_date); ?></h5>
									</a>
								</li>
							<?php } else { ?>
								<li><a href="#0" data-date="<?php echo esc_attr($vestry_timeline_date); ?>">
										<h5><?php echo esc_html($vestry_timeline_date); ?></h5>
									</a>
								</li>
							<?php } ?>
						<?php $counter++;
						endforeach; ?>
					</ol>
					<span class="aheto-timeline__filling-line" aria-hidden="true"></span>
				</div>
			</div>
		</div>
	</section>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/vestry_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {

    let timelines = $('.aheto-timeline--vestry-modern'),
        eventsMinDistance = 55;

    (timelines.length > 0) && initTimeline(timelines);

    function initTimeline(timelines) {
        timelines.each(function () {

            const timeline = $(this),
                timelineComponents = {};

            //cache timeline components
            timelineComponents['timelineWrapper'] = timeline.find('.aheto-timeline__events-wrapper');
            timelineComponents['eventsWrapper'] = timelineComponents['timelineWrapper'].children('.aheto-timeline__events');
            timelineComponents['fillingLine'] = timelineComponents['eventsWrapper'].children('.aheto-timeline__filling-line');
            timelineComponents['timelineEvents'] = timelineComponents['eventsWrapper'].find('a');
            timelineComponents['timelineDates'] = parseDate(timelineComponents['timelineEvents']);
            timelineComponents['eventsMinLapse'] = minLapse(timelineComponents['timelineDates']);
            timelineComponents['timelineNavigation'] = timeline.find('.aheto-timeline__navigation');
            timelineComponents['eventsContent'] = timeline.children('.aheto-timeline__events-content');


            //assign a left postion to the single events along the timeline
            setDatePosition(timelineComponents, eventsMinDistance);
            //assign a width to the timeline
            let timelineTotWidth = setTimelineWidth(timelineComponents, eventsMinDistance);

            //the timeline has been initialize - show it
            timeline.addClass('loaded');


            $(window).on('resize orientationchange', function () {
                const timelineLastDate =  timelineComponents['eventsWrapper'].find('li').last().find('a');
                if(timelineLastDate.hasClass('selected')){
                    // updateSlide(timelineComponents, timelineTotWidth, 'next');
                    setTimeout(updateSlide, 100, timelineComponents, timelineTotWidth, 'next');
                }
            });

             //detect click on the next arrow
            timelineComponents['timelineNavigation'].on('click', '.next', function (event) {
                event.preventDefault();
                updateSlide(timelineComponents, timelineTotWidth, 'next');
            });
            //detect click on the prev arrow
            timelineComponents['timelineNavigation'].on('click', '.prev', function (event) {
                event.preventDefault();
                updateSlide(timelineComponents, timelineTotWidth, 'prev');
            });
            //detect click on the a single event - show new event content
            timelineComponents['eventsWrapper'].on('click', 'a', function (event) {
                event.preventDefault();
                timelineComponents['timelineEvents'].removeClass('selected');
                $(this).addClass('selected');
                updateOlderEvents($(this));
                updateFilling($(this), timelineComponents['fillingLine'], timelineTotWidth);
                updateVisibleContent($(this), timelineComponents['eventsContent']);
            });

            //on swipe, show next/prev event content
            timelineComponents['eventsContent'].on('swipeleft', function () {
                const mq = checkMQ();
                (mq == 'mobile') && showNewContent(timelineComponents, timelineTotWidth, 'next');
            });
            timelineComponents['eventsContent'].on('swiperight', function () {
                const mq = checkMQ();
                (mq == 'mobile') && showNewContent(timelineComponents, timelineTotWidth, 'prev');
            });

            //keyboard navigation
            $(document).keyup(function (event) {
                if (event.which == '37' && elementInViewport(timeline.get(0))) {
                    showNewContent(timelineComponents, timelineTotWidth, 'prev');
                } else if (event.which == '39' && elementInViewport(timeline.get(0))) {
                    showNewContent(timelineComponents, timelineTotWidth, 'next');
                }
            });
        });
    }




    function updateSlide(timelineComponents, timelineTotWidth, string) {
        //retrieve translateX value of timelineComponents['eventsWrapper']
        const translateValue = getTranslateValue(timelineComponents['eventsWrapper']),
            wrapperWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', ''));
        //translate the timeline to the left('next')/right('prev')
        (string == 'next')
            ? translateTimeline(timelineComponents, translateValue - wrapperWidth + eventsMinDistance, wrapperWidth - timelineTotWidth)
            : translateTimeline(timelineComponents, translateValue + wrapperWidth - eventsMinDistance);
    }

    function showNewContent(timelineComponents, timelineTotWidth, string) {
        //go from one event to the next/previous one
        const visibleContent = timelineComponents['eventsContent'].find('.selected'),
            newContent = (string == 'next') ? visibleContent.next() : visibleContent.prev();

        if (newContent.length > 0) { //if there's a next/prev event - show it
            const selectedDate = timelineComponents['eventsWrapper'].find('.selected'),
                newEvent = (string == 'next') ? selectedDate.parent('li').next('li').children('a') : selectedDate.parent('li').prev('li').children('a');

            updateFilling(newEvent, timelineComponents['fillingLine'], timelineTotWidth);
            updateVisibleContent(newEvent, timelineComponents['eventsContent']);
            newEvent.addClass('selected');
            selectedDate.removeClass('selected');
            updateOlderEvents(newEvent);
            updateTimelinePosition(string, newEvent, timelineComponents, timelineTotWidth);
        }
    }

    function updateTimelinePosition(string, event, timelineComponents, timelineTotWidth) {
        //translate timeline to the left/right according to the position of the selected event
        const eventStyle = window.getComputedStyle(event.get(0), null),
            eventLeft = Number(eventStyle.getPropertyValue("left").replace('px', '')),
            timelineWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', ''));

        timelineTotWidth = Number(timelineComponents['eventsWrapper'].css('width').replace('px', ''));
        const timelineTranslate = getTranslateValue(timelineComponents['eventsWrapper']);

        if ((string == 'next' && eventLeft > timelineWidth - timelineTranslate) || (string == 'prev' && eventLeft < -timelineTranslate)) {
            translateTimeline(timelineComponents, -eventLeft + timelineWidth / 2, timelineWidth - timelineTotWidth);
        }
    }


    function translateTimeline(timelineComponents, value, totWidth) {
        const eventsWrapper = timelineComponents['eventsWrapper'].get(0);
        value = (value > 0) ? 0 : value; //only negative translate value
        value = (!(typeof totWidth === 'undefined') && value < totWidth) ? totWidth : value; //do not translate more than timeline width
        setTransformValue(eventsWrapper, 'translateX', value + 'px');
        //update navigation arrows visibility
        (value == 0) ? timelineComponents['timelineNavigation'].find('.prev').addClass('inactive') : timelineComponents['timelineNavigation'].find('.prev').removeClass('inactive');
        (value == totWidth) ? timelineComponents['timelineNavigation'].find('.next').addClass('inactive') : timelineComponents['timelineNavigation'].find('.next').removeClass('inactive');
    }




    function updateFilling(selectedEvent, filling, totWidth) {
        //change .aheto-timeline__filling-line length according to the selected event
        const eventStyle = window.getComputedStyle(selectedEvent.get(0), null);
        let eventLeft = eventStyle.getPropertyValue("left");
        const eventWidth = eventStyle.getPropertyValue("width");
        eventLeft = Number(eventLeft.replace('px', '')) + Number(eventWidth.replace('px', '')) / 2;
        const scaleValue = eventLeft / totWidth;
        setTransformValue(filling.get(0), 'scaleX', scaleValue);
    }

    function setDatePosition(timelineComponents, min) {
        for (let i = 0; i < timelineComponents['timelineDates'].length; i++) {
            const distance = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][i]),
                distanceNorm = Math.round(distance / timelineComponents['eventsMinLapse']) + 2;
            timelineComponents['timelineEvents'].eq(i).css('left', distanceNorm * min + 'px');
        }
    }

    function setTimelineWidth(timelineComponents, width) {
        const timeSpan = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][timelineComponents['timelineDates'].length - 1]);
        let timeSpanNorm = timeSpan / timelineComponents['eventsMinLapse'];
        timeSpanNorm = Math.round(timeSpanNorm) + 4;
        const totalWidth = timeSpanNorm * width;
        // timelineComponents['eventsWrapper'].css('width', totalWidth + 'px');
        updateFilling(timelineComponents['timelineEvents'].eq(0), timelineComponents['fillingLine'], totalWidth);

        return totalWidth;
    }


    function updateVisibleContent(event, eventsContent) {
        const eventDate = event.data('date'),
            visibleContent = eventsContent.find('.selected'),
            selectedContent = eventsContent.find('[data-date="' + eventDate + '"]'),
            selectedContentHeight = selectedContent.height();
        let classEnetering,
            classLeaving;

        if (selectedContent.index() > visibleContent.index()) {
            classEnetering = 'selected enter-right';
            classLeaving = 'leave-left';
        } else {
            classEnetering = 'selected enter-left';
            classLeaving = 'leave-right';
        }


        selectedContent.attr('class', classEnetering);
        visibleContent.attr('class', classLeaving).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
            visibleContent.removeClass('leave-right leave-left');
            selectedContent.removeClass('enter-left enter-right');
        });
        eventsContent.css('height', selectedContentHeight + 'px');
    }

    function updateOlderEvents(event) {
        event.parent('li').prevAll('li').children('a').addClass('older-event').end().end().nextAll('li').children('a').removeClass('older-event');
    }

    function getTranslateValue(timeline) {
        const timelineStyle = window.getComputedStyle(timeline.get(0), null);
        let timelineTranslate = timelineStyle.getPropertyValue("-webkit-transform") ||
            timelineStyle.getPropertyValue("-moz-transform") ||
            timelineStyle.getPropertyValue("-ms-transform") ||
            timelineStyle.getPropertyValue("-o-transform") ||
            timelineStyle.getPropertyValue("transform");
        let translateValue = 0;

        if (timelineTranslate.indexOf('(') >= 0) {
            timelineTranslate = timelineTranslate.split('(')[1];
            timelineTranslate = timelineTranslate.split(')')[0];
            timelineTranslate = timelineTranslate.split(',');
            translateValue = timelineTranslate[4];
        }


        return Number(translateValue);
    }

    function setTransformValue(element, property, value) {
        element.style["-webkit-transform"] = property + "(" + value + ")";
        element.style["-moz-transform"] = property + "(" + value + ")";
        element.style["-ms-transform"] = property + "(" + value + ")";
        element.style["-o-transform"] = property + "(" + value + ")";
        element.style["transform"] = property + "(" + value + ")";
    }

    //based on http://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript
    function parseDate(events) {
        const dateArrays = [];
        events.each(function () {
            const dateComp = $(this).data('date'),
                newDate = new Date(dateComp);
            dateArrays.push(newDate);

        });
        return dateArrays;
    }


    function daydiff(first, second) {
        return Math.round((second - first));
    }

    function minLapse(dates) {
        //determine the minimum distance among events
        const dateDistances = [];
        for (let i = 1; i < dates.length; i++) {
            const distance = daydiff(dates[i - 1], dates[i]);
            dateDistances.push(distance);
        }
        return Math.min.apply(null, dateDistances);
    }

    /*
        How to tell if a DOM element is visible in the current viewport?
        http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
    */
    function elementInViewport(el) {
        let top = el.offsetTop;
        let left = el.offsetLeft;
        let width = el.offsetWidth;
        let height = el.offsetHeight;

        while (el.offsetParent) {
            el = el.offsetParent;
            top += el.offsetTop;
            left += el.offsetLeft;
        }

        return (
            top < (window.pageYOffset + window.innerHeight) &&
            left < (window.pageXOffset + window.innerWidth) &&
            (top + height) > window.pageYOffset &&
            (left + width) > window.pageXOffset
        );
    }

    function checkMQ() {
        //check if mobile or desktop device
        return window.getComputedStyle(document.querySelector('.aheto-timeline--vestry-modern'), '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
    }
})(jQuery, window, document);
	</script>
	<?php
endif;