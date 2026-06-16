import { registerBlockBindingsSource } from '@wordpress/blocks';
import { select } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { dateI18n, getSettings as getDateSettings } from '@wordpress/date';
import { __ } from '@wordpress/i18n';

registerBlockBindingsSource( {
	name: 'site-functionality/project-date',
	label: __( 'Project Date', 'site-functionality' ),
	usesContext: [ 'postId', 'postType' ],
	getFieldsList() {
		return [
			{
				label: __( 'Start Date', 'site-functionality' ),
				type: 'string',
				args: { key: 'start_date' },
			},
			{
				label: __( 'End Date', 'site-functionality' ),
				type: 'string',
				args: { key: 'end_date' },
			},
		];
	},
	getValues( { bindings, context } ) {
		const { postId, postType } = context;
		const record = select( coreStore ).getEditedEntityRecord( 'postType', postType, postId );
		const meta = record?.meta ?? {};

		const site = select( coreStore ).getEntityRecord( 'root', 'site' );
		const dateSettings = getDateSettings();
		const siteFormat = site?.date_format ?? dateSettings.formats.date;

		return Object.fromEntries(
			Object.entries( bindings ).map( ( [ attr, binding ] ) => {
				const key = binding.args?.key;
				const raw = meta[ key ];

				if ( ! raw ) {
					return [ attr, undefined ];
				}

				return [ attr, dateI18n( siteFormat, raw ) ];
			} )
		);
	},
} );

registerBlockBindingsSource( {
	name: 'site-functionality/project-clients',
	label: __( 'Clients', 'site-functionality' ),
	usesContext: [ 'postId', 'postType' ],
	getFieldsList() {
		return [
			{
				label: __( 'Clients', 'site-functionality' ),
				type: 'string',
				args: {},
			},
		];
	},
	getValues( { bindings, context } ) {
		const { postId, postType } = context;
		const record = select( coreStore ).getEditedEntityRecord( 'postType', postType, postId );
		const meta = record?.meta ?? {};
		const clients = meta.clients;

		if ( ! Array.isArray( clients ) || clients.length === 0 ) {
			return Object.fromEntries(
				Object.keys( bindings ).map( ( attr ) => [ attr, undefined ] )
			);
		}

		const items = clients
			.filter( ( client ) => client.client_name )
			.map( ( client ) => {
				const label   = client.client_name;
				const url     = client.client_url;
				const content = url ? `<a href="${ url }">${ label }</a>` : label;
				return `<li>${ content }</li>`;
			} )
			.join( '' );

		const value = items || undefined;

		return Object.fromEntries(
			Object.keys( bindings ).map( ( attr ) => [ attr, value ] )
		);
	},
} );

registerBlockBindingsSource( {
	name: 'site-functionality/project-company',
	label: __( 'Project Company', 'site-functionality' ),
	usesContext: [ 'postId', 'postType' ],
	getFieldsList() {
		return [
			{
				label: __( 'Company', 'site-functionality' ),
				type: 'string',
				args: {},
			},
		];
	},
	getValues( { bindings, context } ) {
		const { postId, postType } = context;
		const record = select( coreStore ).getEditedEntityRecord( 'postType', postType, postId );
		const meta = record?.meta ?? {};

		const company = meta.company;
		const url     = meta.url;

		const value = company && url
			? `<a href="${ url }">${ company }</a>`
			: company ?? undefined;

		return Object.fromEntries(
			Object.keys( bindings ).map( ( attr ) => [ attr, value ] )
		);
	},
} );
