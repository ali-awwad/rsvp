import React from 'react'
import { CalendarIcon, ClockIcon, MapPinIcon } from '@heroicons/react/24/outline'
import ParkingIcon from '@/Shared/ParkingIcon'

export default function CampaignInfo({campaign}) {
    return (
        <div className="px-4 sm:px-6 sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left lg:flex lg:items-center">
            <div>

                <h1 className="mt-4 text-4xl tracking-tight font-extrabold text-rsvp-darkblue sm:mt-5 sm:leading-none lg:mt-6 lg:text-5xl xl:text-6xl">
                    <span className="md:block">{campaign.title}</span>
                </h1>
                <p className="mt-3 text-base text-gray-700 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                    {campaign.description}
                </p>
                <div className='mt-4 text-rsvp-purple font-bold'>
                    <div className="text-3xl">
                        <MapPinIcon className='inline w-10 h-10 mr-2' />
                        {campaign.location}
                    </div>
                    <a href={campaign.parking_link} className='mb-4 block pl-3 text-rsvp-darkblue text-base hover:underline'>
                        <ParkingIcon className='inline w-4 h-4 mr-2 fill-current' />
                        {campaign.parking}
                    </a>
                    <div className="mb-4 text-3xl">
                        <CalendarIcon className='inline w-10 h-10 mr-2' />
                        {campaign.start_date}
                    </div>
                    <div className="mb-4 text-3xl">
                        <ClockIcon className='inline w-10 h-10 mr-2' />
                        {campaign.start_time}
                    </div>
                </div>

            </div>
        </div>
    )
}
