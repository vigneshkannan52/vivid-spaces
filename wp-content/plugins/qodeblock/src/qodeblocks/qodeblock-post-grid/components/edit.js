/**
 * External dependencies
 */

import isUndefined from 'lodash/isUndefined';
import pickBy from 'lodash/pickBy';
import moment from 'moment';
import classnames from 'classnames';
import Inspector from './inspector';
import PostGridImage from './image';

const { compose } = wp.compose;

const { Component, Fragment } = wp.element;

const { __ } = wp.i18n;

const { decodeEntities } = wp.htmlEntities;

const {
	withSelect,
} = wp.data;

const {
	Placeholder,
	Spinner,
	Toolbar,
} = wp.components;

const {
	BlockAlignmentToolbar,
	BlockControls,
} = wp.editor;

class LatestPostsBlock extends Component {

	render() {
		const {
			attributes,
			setAttributes,
			latestPosts,
		} = this.props;

		// Check if there are posts
		const hasPosts = Array.isArray( latestPosts ) && latestPosts.length;

		// Check the post type
		const isPost = attributes.postType === 'post';

		if ( ! hasPosts ) {
			return (
				<Fragment>
					<Inspector
						{ ...{ setAttributes, ...this.props } }
					/>
					<Placeholder
						icon="admin-post"
						label={ __( 'Qodeblock Post and Page Grid', 'qodeblock' ) }
					>
						{ ! Array.isArray( latestPosts ) ?
							<Spinner /> :
							__( 'No posts found.', 'qodeblock' )
						}
					</Placeholder>
				</Fragment>
			);
		}

		// Removing posts from display should be instant.
		const displayPosts = latestPosts.length > attributes.postsToShow ?
			latestPosts.slice( 0, attributes.postsToShow ) :
			latestPosts;

		// Add toolbar controls to change layout
		const layoutControls = [
			{
				icon: 'grid-view',
				title: __( 'Grid View', 'qodeblock' ),
				onClick: () => setAttributes( { postLayout: 'grid' } ),
				isActive: attributes.postLayout === 'grid',
			},
			{
				icon: 'list-view',
				title: __( 'List View', 'qodeblock' ),
				onClick: () => setAttributes( { postLayout: 'list' } ),
				isActive: attributes.postLayout === 'list',
			},
		];

		// Get the section tag
		const SectionTag = attributes.sectionTag ? attributes.sectionTag : "section";

		// Get the section title tag
		const SectionTitleTag = attributes.sectionTitleTag ? attributes.sectionTitleTag : "h2";

		// Get the post title tag
		const PostTag = attributes.postTitleTag ? attributes.postTitleTag : "h3";

		return (
			<Fragment>
				<Inspector
					{ ...{ setAttributes, ...this.props } }
				/>
				<BlockControls>
					<BlockAlignmentToolbar
						value={ attributes.align }
						onChange={ ( value ) => {
							setAttributes( { align: value } );
						} }
						controls={ [ 'center', 'wide', 'full' ] }
					/>
					<Toolbar controls={ layoutControls } />
				</BlockControls>
				<SectionTag
					className={ classnames(
						this.props.className,
						'qb-block-post-grid',
					) }
				>
					{ attributes.displaySectionTitle && attributes.sectionTitle &&
						<SectionTitleTag className="qb-post-grid-section-title">{ attributes.sectionTitle }</SectionTitleTag>
					}

					<div
						className={ classnames( {
							'is-grid': attributes.postLayout === 'grid',
							'is-list': attributes.postLayout === 'list',
							[ `columns-${ attributes.columns }` ]: attributes.postLayout === 'grid',
							'qb-post-grid-items' : 'qb-post-grid-items'
						} ) }
					>
						{ displayPosts.map( ( post, i ) =>
							<article
								key={ i }
								id={ 'post-' + post.id }
								className={ classnames(
									'post-' + post.id,
									post.featured_image_src && attributes.displayPostImage ? 'has-post-thumbnail' : null
								) }
							>
								{
									attributes.displayPostImage && post.featured_media ? (
										<PostGridImage
											{ ...this.props }
											imgAlt={ decodeEntities( post.title.rendered.trim() ) || __( '(Untitled)', 'qodeblock' ) }
											imgClass={ `wp-image-${post.featured_media.toString()}` }
											imgID={ post.featured_media.toString() }
											imgSize={ attributes.imageSize }
											imgSizeLandscape={ post.featured_image_src }
											imgSizeSquare={ post.featured_image_src_square }
											imgLink={ post.link }
										/>
									) : (
										null
									)
								}

								<div className="qb-block-post-grid-text">
									<header className="qb-block-post-grid-header">
										{ attributes.displayPostTitle &&
											<PostTag className="qb-block-post-grid-title"><a href={ post.link } target="_blank" rel="bookmark">{ decodeEntities( post.title.rendered.trim() ) || __( '(Untitled)', 'qodeblock' ) }</a></PostTag>
										}

										{ isPost &&
											<div className="qb-block-post-grid-byline">
												{ attributes.displayPostAuthor && post.author_info.display_name &&
													<div className="qb-block-post-grid-author"><a className="qb-text-link" target="_blank" href={ post.author_info.author_link }>{ post.author_info.display_name }</a></div>
												}

												{ attributes.displayPostDate && post.date_gmt &&
													<time dateTime={ moment( post.date_gmt ).utc().format() } className={ 'qb-block-post-grid-date' }>
														{ moment( post.date_gmt ).local().format( 'MMMM DD, Y', 'qodeblock' ) }
													</time>
												}
											</div>
										}
									</header>

									<div className="qb-block-post-grid-excerpt">
										{ attributes.displayPostExcerpt && post.excerpt &&
											<div dangerouslySetInnerHTML={ { __html: truncate( post.excerpt.rendered, attributes.excerptLength ) } } />
										}

										{ attributes.displayPostLink &&
											<p><a className="qb-block-post-grid-more-link qb-text-link" href={ post.link } target="_blank" rel="bookmark">{ attributes.readMoreText }</a></p>
										}
									</div>
								</div>
							</article>
						) }
					</div>
				</SectionTag>
			</Fragment>
		);
	}
}

export default compose( [
	withSelect( ( select, props ) => {
		const {
			order,
			categories,
		} = props.attributes;

		const { getEntityRecords } = select( 'core', 'qodeblock' );

		const latestPostsQuery = pickBy( {
			categories,
			order,
			orderby: props.attributes.orderBy,
			per_page: props.attributes.postsToShow,
			offset: props.attributes.offset,
		}, ( value ) => ! isUndefined( value ) );

		return {
			latestPosts: getEntityRecords( 'postType', props.attributes.postType, latestPostsQuery ),
		};
	} ),
] )( LatestPostsBlock );

// Truncate excerpt
function truncate(str, no_words) {
	return str.split(" ").splice(0,no_words).join(" ");
}
