import { useState, useEffect } from 'react'
import { PaperAirplaneIcon, ArrowPathIcon } from '@heroicons/react/24/outline'
import Tabs from '@/Shared/Tabs'
import { Head, usePage, useForm } from '@inertiajs/react'
import SuccessModal from '@/Shared/SuccessModal'
import CampaignInfo from './CampaignInfo'

export default function Show() {
    const { campaign, title, flash, replies, country_codes } = usePage().props;
    const defaultCountryCode = country_codes.find(country_code => country_code.defaultSelected)?.code;
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        first_name: '',
        last_name: '',
        mobile: '',
        country_code: defaultCountryCode,
        company: '',
        reply: replies[0].value,
        notes: '',
    });


    function handleSubmit(event) {
        event.preventDefault();
        post(`/campaigns/${campaign.data.uuid}`);
    }

    function handleChange(e) {
        const key = e.target.id;
        const value = e.target.value;
        setData(key, value);
    }

    return (
        <>
            <Head title={title} />

            <div className="relative overflow-hidden">
                <div className="relative pt-6 pb-16">
                    <main className="mt-10">
                        <div className="mx-auto max-w-7xl">
                            <div className="lg:grid lg:grid-cols-12 lg:gap-8">

                                <CampaignInfo campaign={campaign.data} />

                                <div className="mt-16 sm:mt-24 lg:mt-0 lg:col-span-6">
                                    <div className="bg-white sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
                                        <div className="px-4 py-8 sm:px-10">
                                            <p className="text-sm font-medium text-gray-700">Please fill out the information below to register
                                                for the event
                                            </p>
                                            <Tabs replies={replies} setData={setData} data={data} />
                                            <div className="mt-6">
                                                <form onSubmit={handleSubmit} method="POST" className="space-y-3">
                                                    <div>
                                                        <label htmlFor="first_name" className="sr-only">
                                                            First Name
                                                        </label>
                                                        <input
                                                            type="text"
                                                            name="first_name"
                                                            id="first_name"
                                                            onChange={handleChange}
                                                            autoComplete="given-name"
                                                            placeholder="First Name"
                                                            // required
                                                            className="form-input"
                                                            disabled={processing}
                                                        />
                                                        {errors.first_name && <p className='text-red-500 text-sm'>{errors.first_name}</p>}
                                                    </div>
                                                    <div>
                                                        <label htmlFor="last_name" className="sr-only">
                                                            Family Name
                                                        </label>
                                                        <input
                                                            type="text"
                                                            name="last_name"
                                                            id="last_name"
                                                            onChange={handleChange}
                                                            autoComplete="family-name"
                                                            placeholder="Family Name"
                                                            // required
                                                            className="form-input"
                                                            disabled={processing}
                                                        />
                                                        {errors.last_name && <p className='text-red-500 text-sm'>{errors.last_name}</p>}
                                                    </div>

                                                    <div>
                                                        <label htmlFor="email" className="sr-only">
                                                            Email Address
                                                        </label>
                                                        <input
                                                            type="email"
                                                            name="email"
                                                            id="email"
                                                            onChange={handleChange}
                                                            autoComplete="email"
                                                            placeholder="Email Address"
                                                            // required
                                                            className="form-input"
                                                            disabled={processing}
                                                        />
                                                        {errors.email && <p className='text-red-500 text-sm'>{errors.email}</p>}
                                                    </div>
                                                    <div className='grid grid-cols-6 gap-4'>
                                                        <div className="col-span-2">
                                                            <label htmlFor="country_code" className="sr-only">
                                                                Country code
                                                            </label>
                                                            <select
                                                                name="country_code"
                                                                id="country_code"
                                                                onChange={handleChange}
                                                                autoComplete="country-code"
                                                                placeholder="Country code"
                                                                // required
                                                                className="form-input"
                                                                defaultValue={country_codes.find(country_code => country_code.defaultSelected)?.code}
                                                                disabled={processing}
                                                            >
                                                                {country_codes.map((country_code, index) => (
                                                                    <option key={index} value={country_code.code}>
                                                                        {country_code.name} ({country_code.code})
                                                                    </option>
                                                                ))}
                                                            </select>
                                                            {errors.country_code && <p className='text-red-500 text-sm'>{errors.country_code}</p>}
                                                        </div>
                                                        <div className="col-span-4">
                                                            <label htmlFor="mobile" className="sr-only">
                                                                Mobile number
                                                            </label>
                                                            <input
                                                                type="text"
                                                                name="mobile"
                                                                id="mobile"
                                                                onChange={handleChange}
                                                                autoComplete="tel"
                                                                placeholder="Mobile number"
                                                                // required
                                                                className="form-input"
                                                                disabled={processing}
                                                            />
                                                            {errors.mobile && <p className='text-red-500 text-sm'>{errors.mobile}</p>}
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label htmlFor="company" className="sr-only">
                                                            Company
                                                        </label>
                                                        <input
                                                            type="text"
                                                            name="company"
                                                            id="company"
                                                            onChange={handleChange}
                                                            autoComplete="company"
                                                            placeholder="Company"

                                                            className="form-input"
                                                            disabled={processing}
                                                        />
                                                        {errors.company && <p className='text-red-500 text-sm'>{errors.company}</p>}
                                                    </div>

                                                    <div>
                                                        <label htmlFor="notes" className="sr-only">
                                                            Notes
                                                        </label>
                                                        <textarea
                                                            name="notes"
                                                            id="notes"
                                                            onChange={handleChange}
                                                            placeholder="Notes"
                                                            className="form-input"
                                                            disabled={processing}
                                                        />
                                                        {errors.notes && <p className='text-red-500 text-sm'>{errors.notes}</p>}
                                                    </div>

                                                    <div>
                                                        <button
                                                            type="submit"
                                                            disabled={processing}
                                                            className="btn btn-primary "
                                                        >
                                                            {processing && <ArrowPathIcon className='animate-spin w-4 h-4 mr-1' />}
                                                            {!processing && <PaperAirplaneIcon className='w-4 h-4 mr-1' />}
                                                            Submit
                                                        </button>
                                                    </div>
                                                    {flash.error &&
                                                        <p className='text-red-500 bg-red-50 border-red-200 p-4 my-4'>
                                                            {flash.error}
                                                        </p>
                                                    }
                                                    {flash.success &&
                                                        <SuccessModal message={flash.success} />
                                                    }
                                                </form>
                                            </div>
                                        </div>
                                        <div className="px-4 py-6 bg-gray-50 border-t-2 border-gray-200 sm:px-10">
                                            <p className="text-xs leading-5 text-gray-500">
                                                By signing up, you agree to our{' '}
                                                <a href="#" className="font-medium text-gray-900 hover:underline">
                                                    Terms
                                                </a>
                                                ,{' '}
                                                <a href="#" className="font-medium text-gray-900 hover:underline">
                                                    Data Policy
                                                </a>{' '}
                                                and{' '}
                                                <a href="#" className="font-medium text-gray-900 hover:underline">
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
