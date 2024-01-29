/**
 * Inspector Controls
 */

// Setup the block
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;

import compact from 'lodash/compact';
import map from 'lodash/map';

// Import block components
const {
  InspectorControls,
} = wp.editor;

// Import Inspector components
const {
	PanelBody,
	QueryControls,
	RangeControl,
	SelectControl,
	TextControl,
	ToggleControl,
} = wp.components;

const { addQueryArgs } = wp.url;

const { apiFetch } = wp;

const MAX_POSTS_COLUMNS = 4;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Inspector extends Component {

	constructor() {
		super( ...arguments );
		this.state = { categoriesList: [] }
	}

	componentDidMount() {
		this.stillMounted = true;
		this.fetchRequest = apiFetch( {
			path: addQueryArgs( '/wp/v2/categories', { per_page: -1 } )
		} ).then(
			( categoriesList ) => {
				if ( this.stillMounted ) {
					this.setState( { categoriesList } );
				}
			}
		).catch(
			() => {
				if ( this.stillMounted ) {
					this.setState( { categoriesList: [] } );
				}
			}
		);
	}

	componentWillUnmount() {
		this.stillMounted = false;
	}

	/* Get the available image sizes */
	imageSizeSelect() {
		const getSettings = wp.data.select( 'core/editor' ).getEditorSettings();

		return compact( map( getSettings.imageSizes, ( { name, slug } ) => {
			return {
				value: slug,
				label: name,
			};
		} ) );
	}

	render() {

		// Setup the attributes
		const {
			attributes,
			setAttributes,
			latestPosts
		} = this.props;

		const {
			order,
			orderBy,
		} = attributes;

		const { categoriesList } = this.state;

		// Thumbnail options
		const imageCropOptions = [
			{ value: 'landscape', label: __( 'Landscape', 'qodeblock' ) },
			{ value: 'square', label: __( 'Square', 'qodeblock' ) },
		];

		// Post type options
		const postTypeOptions = [
			{ value: 'post', label: __( 'Post', 'qodeblock' ) },
			{ value: 'page', label: __( 'Page', 'qodeblock' ) },
		];

		// Section title tags
		const sectionTags = [
			{ value: 'div', label: __( 'div', 'qodeblock' ) },
			{ value: 'header', label: __( 'header', 'qodeblock' ) },
			{ value: 'section', label: __( 'section', 'qodeblock' ) },
			{ value: 'article', label: __( 'article', 'qodeblock' ) },
			{ value: 'main', label: __( 'main', 'qodeblock' ) },
			{ value: 'aside', label: __( 'aside', 'qodeblock' ) },
			{ value: 'footer', label: __( 'footer', 'qodeblock' ) },
		];

		// Section title tags
		const sectionTitleTags = [
			{ value: 'h2', label: __( 'H2', 'qodeblock' ) },
			{ value: 'h3', label: __( 'H3', 'qodeblock' ) },
			{ value: 'h4', label: __( 'H4', 'qodeblock' ) },
			{ value: 'h5', label: __( 'H5', 'qodeblock' ) },
			{ value: 'h6', label: __( 'H6', 'qodeblock' ) },
		];

		// Check for posts
		const hasPosts = Array.isArray( latestPosts ) && latestPosts.length;

		// Check the post type
		const isPost = attributes.postType === 'post';

		// Add instruction text to the select
		const qbImageSizeSelect = {
			value: 'selectimage',
			label: __( 'Select image size' ),
		};

		// Add the landscape image size to the select
		const qbImageSizeLandscape = {
			value: 'qb-post-grid-image-landscape',
			label: __( 'Grid Landscape' ),
		};

		// Add the square image size to the select
		const qbImageSizeSquare = {
			value: 'qb-post-grid-image-square',
			label: __( 'Grid Square' ),
		};

		// Get the image size options
		const imageSizeOptions = this.imageSizeSelect();

		// Combine the objects
		imageSizeOptions.push( qbImageSizeSquare, qbImageSizeLandscape );
		imageSizeOptions.unshift( qbImageSizeSelect );

		const imageSizeValue = () => {
			for ( var i = 0; i < imageSizeOptions.length; i++ ) {
				if ( imageSizeOptions[i].value === attributes.imageSize ) {
					return attributes.imageSize;
				}
			}
			return 'full';
		};

		return (
			<InspectorControls>
				<PanelBody
					title={ __( 'Post and Page Grid Settings', 'qodeblock' ) }
					className={ isPost ? null : 'qodeblock-hide-query' }
				>
					<SelectControl
						label={ __( 'Content Type', 'qodeblock' ) }
						options={ postTypeOptions }
						value={ attributes.postType }
						onChange={ ( value ) => this.props.setAttributes( { postType: value } ) }
					/>
					<QueryControls
						{ ...{ order, orderBy } }
						numberOfItems={ attributes.postsToShow }
						categoriesList={ categoriesList }
						selectedCategoryId={ attributes.categories }
						onOrderChange={ ( value ) => setAttributes( { order: value } ) }
						onOrderByChange={ ( value ) => setAttributes( { orderBy: value } ) }
						onCategoryChange={ ( value ) => setAttributes( { categories: '' !== value ? value : undefined } ) }
						onNumberOfItemsChange={ ( value ) => setAttributes( { postsToShow: value } ) }
					/>
					<RangeControl
						label={ __( 'Number of items to offset', 'qodeblock' ) }
						value={ attributes.offset }
						onChange={ ( value ) => setAttributes( { offset: value } ) }
						min={ 0 }
						max={ 20 }
					/>
					{ attributes.postLayout === 'grid' &&
						<RangeControl
							label={ __( 'Columns', 'qodeblock' ) }
							value={ attributes.columns }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
							min={ 2 }
							max={ ! hasPosts ? MAX_POSTS_COLUMNS : Math.min( MAX_POSTS_COLUMNS, latestPosts.length ) }
						/>
					}
				</PanelBody>
				<PanelBody
					title={ __( 'Post and Page Grid Content', 'qodeblock' ) }
					initialOpen={ false }
				>
					<ToggleControl
						label={ __( 'Display Section Title', 'qodeblock' ) }
						checked={ attributes.displaySectionTitle }
						onChange={ () => this.props.setAttributes( { displaySectionTitle: ! attributes.displaySectionTitle } ) }
					/>
					{ attributes.displaySectionTitle &&
						<TextControl
							label={ __( 'Section Title', 'qodeblock' ) }
							type="text"
							value={ attributes.sectionTitle }
							onChange={ ( value ) => this.props.setAttributes( { sectionTitle: value } ) }
						/>
					}
					<ToggleControl
						label={ __( 'Display Featured Image', 'qodeblock' ) }
						checked={ attributes.displayPostImage }
						onChange={ () => this.props.setAttributes( { displayPostImage: ! attributes.displayPostImage } ) }
					/>
					{ attributes.displayPostImage &&
						<SelectControl
							label={ __( 'Image Size', 'qodeblock' ) }
							value={ imageSizeValue() }
							options={ imageSizeOptions }
							onChange={ ( value ) => this.props.setAttributes( { imageSize: value } ) }
						/>
					}
					{ attributes.displayPostImage &&
						<Fragment>
							<SelectControl
								label={ __( 'Featured Image Style', 'qodeblock' ) }
								options={ imageCropOptions }
								value={ attributes.imageCrop }
								onChange={ ( value ) => this.props.setAttributes( { imageCrop: value } ) }
							/>
						</Fragment>
					}
					<ToggleControl
						label={ __( 'Display Title', 'qodeblock' ) }
						checked={ attributes.displayPostTitle }
						onChange={ () => this.props.setAttributes( { displayPostTitle: ! attributes.displayPostTitle } ) }
					/>
					{ isPost &&
						<ToggleControl
							label={ __( 'Display Author', 'qodeblock' ) }
							checked={ attributes.displayPostAuthor }
							onChange={ () => this.props.setAttributes( { displayPostAuthor: ! attributes.displayPostAuthor } ) }
						/>
					}
					{ isPost &&
						<ToggleControl
							label={ __( 'Display Date', 'qodeblock' ) }
							checked={ attributes.displayPostDate }
							onChange={ () => this.props.setAttributes( { displayPostDate: ! attributes.displayPostDate } ) }
						/>
					}
					<ToggleControl
						label={ __( 'Display Excerpt', 'qodeblock' ) }
						checked={ attributes.displayPostExcerpt }
						onChange={ () => this.props.setAttributes( { displayPostExcerpt: ! attributes.displayPostExcerpt } ) }
					/>
					{ attributes.displayPostExcerpt &&
						<RangeControl
							label={ __( 'Excerpt Length', 'qodeblock' ) }
							value={ attributes.excerptLength }
							onChange={ ( value ) => setAttributes( { excerptLength: value } ) }
							min={ 0 }
							max={ 150 }
						/>
					}
					<ToggleControl
						label={ __( 'Display Continue Reading Link', 'qodeblock' ) }
						checked={ attributes.displayPostLink }
						onChange={ () => this.props.setAttributes( { displayPostLink: ! attributes.displayPostLink } ) }
					/>
					{ attributes.displayPostLink &&
						<TextControl
							label={ __( 'Customize Continue Reading Text', 'qodeblock' ) }
							type="text"
							value={ attributes.readMoreText }
							onChange={ ( value ) => this.props.setAttributes( { readMoreText: value } ) }
						/>
					}
				</PanelBody>
				<PanelBody
					title={ __( 'Post and Page Grid Markup', 'qodeblock' ) }
					initialOpen={ false }
					className="qb-block-post-grid-markup-settings"
				>
					<SelectControl
						label={ __( 'Post Grid Section Tag', 'qodeblock' ) }
						options={ sectionTags }
						value={ attributes.sectionTag }
						onChange={ ( value ) => this.props.setAttributes( { sectionTag: value } ) }
						help={ __( 'Change the post grid section tag to match your content hierarchy.', 'qodeblock' ) }
					/>
					{ attributes.sectionTitle &&
						<SelectControl
							label={ __( 'Section Title Heading Tag', 'qodeblock' ) }
							options={ sectionTitleTags }
							value={ attributes.sectionTitleTag }
							onChange={ ( value ) => this.props.setAttributes( { sectionTitleTag: value } ) }
							help={ __( 'Change the post/page section title tag to match your content hierarchy.', 'qodeblock' ) }
						/>
					}
					{ attributes.displayPostTitle &&
						<SelectControl
							label={ __( 'Post Title Heading Tag', 'qodeblock' ) }
							options={ sectionTitleTags }
							value={ attributes.postTitleTag }
							onChange={ ( value ) => this.props.setAttributes( { postTitleTag: value } ) }
							help={ __( 'Change the post/page title tag to match your content hierarchy.', 'qodeblock' ) }
						/>
					}
				</PanelBody>
			</InspectorControls>
		);
	}
}
