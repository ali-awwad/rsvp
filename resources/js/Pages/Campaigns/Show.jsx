import { Head, usePage } from '@inertiajs/react'
import CampaignInfo from './CampaignInfo'
import Form from '@/Shared/Form';

export default function Show() {
    const { campaign, title } = usePage().props;

    return (
        <>
            <Head title={title} />

            <div className="relative overflow-hidden min-h-full">
                {campaign.data.background &&
                    <img
                        src={campaign.data.background}
                        className='absolute inset-0 w-full h-full object-cover opacity-10'
                        alt={`${campaign.data.title} Background`} />
                }
                <div className="relative pt-6 pb-16">
                    <main className="mt-0 lg:mt-10">
                        <div className="mx-auto max-w-7xl">
                            <div className="lg:grid lg:grid-cols-12 lg:gap-8">

                                <CampaignInfo campaign={campaign.data} />

                                <div className="mt-16 sm:mt-24 lg:mt-0 lg:col-span-6">
                                    <div className="bg-white sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
                                        <div className="px-4 py-8 sm:px-10">
                                                <Form campaign={campaign.data} />
                                        </div>
                                        <div className="px-4 py-6 bg-gray-50 border-t-2 border-gray-200 sm:px-10">
                                            <p className="text-xs leading-5 text-gray-500">
                                                By signing up, you agree to our{' '}
                                                <a href={campaign.data.terms_link} target='_blank' className="font-medium text-gray-900 hover:underline">
                                                    Terms
                                                </a>
                                                ,{' '}
                                                <a href={campaign.data.data_policy_link} target='_blank' className="font-medium text-gray-900 hover:underline">
                                                    Data Policy
                                                </a>{' '}
                                                and{' '}
                                                <a href={campaign.data.cookies_policy_link} target='_blank' className="font-medium text-gray-900 hover:underline">
                                                    Cookies Policy
                                                </a>
                                                .
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </>
    )
}
