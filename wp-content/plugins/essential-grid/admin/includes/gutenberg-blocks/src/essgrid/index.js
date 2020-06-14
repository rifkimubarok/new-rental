/**
 * Block dependencies
 */
import './editor.scss';

/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { TextControl, Button } = wp.components;
const { Component } = wp.element;

/**
 * essgrid Editor Element
 */
export  class EssGrid extends Component {

    constructor() {
        super( ...arguments );
        const { attributes: { text,gridTitle } } = this.props;
        this.state = {
          text ,
          gridTitle
        }
    }

    render() {
        const {
        attributes: { text,gridTitle },
        setAttributes  } = this.props;
      
        window.essgrid_react = this;
        const openDialog = () => {
          jQuery('select[name="ess-grid-existing-grid"]').val("-1");
          jQuery('#ess-grid-tiny-mce-dialog').dialog({
            id       : 'ess-grid-tiny-mce-dialog',
            title	 : eg_lang.shortcode_generator,
            width    : 720,
            height   : 'auto'
          });
        }

        const openEdit = () => {
          window.essgrid_react = this;
         
          var shortcode = this.state.text;    
          var attributes = {};
          
          shortcode.match(/[\w-]+=".+?"/g).forEach(function(attribute) {
              attribute = attribute.match(/([\w-]+)="(.+?)"/);
              attributes[attribute[1]] = attribute[2];
          });
          
          if ( typeof attributes.alias === "undefined" ) return false;
          
          self.location.href =  "admin.php?page=essential-grid&view=grid-create&alias=" + attributes.alias;
        }

        return (
          <div className="essgrid_block" >
                  <span>{this.state.gridTitle}&nbsp;</span>
                  <TextControl
                        className="grid_slug"
                        value={ this.state.text }
                        onChange={ ( text ) => setAttributes( { text } ) }
                    />
                  <Button 
                        isDefault
                        onClick = { openEdit } 
                        className="grid_edit_button editor_icon dashicons dashicons-edit"
                    >
                  </Button>
                  <Button 
                        isDefault
                        onClick = { openDialog } 
                        className="grid_edit_button"
                    >
                    {__( 'Select Grid', 'essgrid' )}
                  </Button>
                 
          </div>
        );
    }
}


/**
 * Register block
 */
export default registerBlockType(
    'themepunch/essgrid',
    {
        title: __( 'Add prefined EssGrid', 'essgrid' ),
        description: __( 'Add your predefined Essential Grid.', 'essgrid' ),
        category: 'themepunch',
        icon: {
          src:  'screenoptions',
          background: '#c90000',
          color: 'white'
        },        
        keywords: [
            __( 'image', 'essgrid' ),
            __( 'gallery', 'essgrid' ),
            __( 'grid', 'essgrid' ),
        ],
        attributes: {
          text: {
              selector: '.essgrid',
              type: 'string',
              source: 'text',
          },
          gridTitle: {
              selector: '.essgrid',
              type: 'string',
              source: 'attribute',
             	attribute: 'data-gridtitle',
          },
          alias: {
            type: 'string'
          }
        },
        edit: props => {
          const { setAttributes } = props;
          return (
            <div>
              <EssGrid {...{ setAttributes, ...props }} />
            </div>
          );
        },
        save: props => {
          const { attributes: { text,gridTitle } } = props;
          return (
            <div className="essgrid" data-gridtitle={gridTitle}>
               {text} 
            </div>
          );
        },
    },
);