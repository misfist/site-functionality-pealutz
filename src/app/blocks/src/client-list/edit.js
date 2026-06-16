import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { Placeholder } from '@wordpress/components';
import './editor.scss';

export default function Edit( { context } ) {
	const { postId, postType } = context;

	const clients = useSelect( ( select ) => {
		const record = select( coreStore ).getEditedEntityRecord( 'postType', postType, postId );
		return record?.meta?.clients ?? [];
	}, [ postId, postType ] );

	const blockProps = useBlockProps();

	if ( ! postId || ! postType ) {
		return null;
	}

	if ( ! clients.length ) {
		return (
			<div { ...blockProps }>
				<Placeholder 
					label={ __( 'Client List', 'site-functionality' ) }
				/>
			</div>
		);
	}

	return (
		<div { ...blockProps }>
			<ul className='is-style-pills'>
				{ clients.map( ( client, index ) => (
					<li key={ index }>
						{ client.client_url
							? <a href={ client.client_url }>{ client.client_name }</a>
							: client.client_name
						}
					</li>
				) ) }
			</ul>
		</div>
	);
}
